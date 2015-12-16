<?php
/**
 * 微信服务器与开发者服务器消息交互入口；
 * 开发者可以根据业务情况，自由处理；
 * 在以后的版本更新中，只会更新其他文件；此文件不会再做更新，请开发者知晓；
 */

include_once '../core/model.php';
include_once 'WxProcess.class.php';

$msgApi = new MessageApi();
if($_SERVER['REQUEST_METHOD'] == 'POST') {//POST 请求，数据处理
	$msgApi -> processMsg();
}else{//GET 请求，验证URL TOKEN
	$msgApi -> valid();
}

class MessageApi{
	
	//验证url token
	public function valid(){
		$wxAccount = new Account();
		$wxAccount = $wxAccount -> getSingleAccount();
		$token = $wxAccount['token'];
		
		$echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			echo $echoStr;
			exit;
		}
	}
	
	//处理消息；开发者可以根据自身情况随机处理；
	public function processMsg(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
			$requestMsg = WxProcess::getRequestMsg($postStr);
			
			//订阅消息(subscribe)，返回一条文本消息
			if($requestMsg -> MsgType == MsgType::$Event && $requestMsg -> EventKey == MsgType::$SUBSCRIBE){
				$msgText = new MsgText();
				
				$sql = ' select b.inputCode, t.content from 
				t_wxcms_msg_base b,t_wxcms_msg_text t 
				where t.base_id = b.id and b.inputCode = "' .MsgType::$SUBSCRIBE . '"';
				$querySet = $msgText -> queryBySql($sql);
				
				$msgContent = "欢迎订阅，请回复 1 ";//默认
				if(!empty($querySet)){
					$msgContent = $querySet[0]['content'];
				}
				echo WxProcess::responseText($requestMsg, $contentMsg);
			}else{
				$keyword = null;
				if(!empty($requestMsg->Content)){//返回图文消息
					$keyword = $requestMsg->Content;
				}
				
				$sql = 'select t.* from t_wxcms_msg_base b,t_wxcms_msg_news t 
					where t.base_id = b.id ';
				if(!empty($keyword)){
					$sql .= " and b.inputCode like '%$keyword%' ";
				}
				
				$msgNews = new MsgNews();
				$querySet = $msgNews -> queryBySql($sql);
				
				$newsArr = array();
				if(!empty($querySet)){
					$wxAccount = new Account();
					$wxAccount = $wxAccount -> getSingleAccount();
					$msgCount = $wxAccount['msgCount'];//消息条数
					if($msgCount > count($querySet)){
						$msgCount = count($querySet);
					}
					
					for($i=0; $i<$msgCount; $i++){
						$item = $querySet[$i];
						$news = array(
							"Title" => $item['title'],
							"Description" => $item['brief'],
							"PicUrl" => $item['picPath'],
							"Url" => $item['url'],
						);
						array_push($newsArr, $news);
					}
				}
				echo WxProcess::responseNews($requestMsg, $newsArr);
			}
		}else {
			echo "";
			exit;
		}
	}
	
}

?>