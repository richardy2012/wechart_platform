<?php
	include_once 'wxconsts.php';
	/**
	 *微信消息处理类 
	 */
	class WxProcess {
		
		//转换请求XML消息为对象
		public static function getRequestMsg($postStr){
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$requestMsg = new RequestMsg();
			$requestMsg -> MsgType = $postObj -> MsgType;
			$requestMsg -> MsgId = $postObj -> MsgId;
			$requestMsg -> FromUserName = $postObj -> FromUserName;
			$requestMsg -> ToUserName = $postObj -> ToUserName;
			$requestMsg -> CreateTime = $postObj -> CreateTime;
			
			if($postObj->MsgType == MsgType::$TEXT){//文本消息
				$requestMsg -> Content = $postObj -> Content;
			}
			if($postObj->MsgType == MsgType::$Image){//图片消息
				$requestMsg -> PicUrl = $postObj -> PicUrl;
			}
			if($postObj->MsgType == MsgType::$Location){//地理位置消息
				$requestMsg -> Location_X = $postObj -> Location_X;
				$requestMsg -> Location_Y = $postObj -> Location_Y;
				$requestMsg -> Scale = $postObj -> Scale;
				$requestMsg -> Label = $postObj -> Label;
			}
			if($postObj->MsgType == MsgType::$Event){//事件消息
				$requestMsg -> Event = $postObj -> Event;
				$requestMsg -> EventKey = $postObj -> EventKey;
				if($postObj -> Event == MsgType::$EVENT_LOCATION){
					$requestMsg -> Latitude = $postObj -> Latitude;
					$requestMsg -> Longitude = $postObj -> Longitude;
					$requestMsg -> Precision = $postObj -> Precision;
				}
			}
			return $requestMsg;
		}
		
		//回复文本消息
		public static function responseText($requestMsg, $contentMsg){
	        $textTpl = "<xml>
	        <FromUserName><![CDATA[%s]]></FromUserName>
	        <ToUserName><![CDATA[%s]]></ToUserName>
	        <CreateTime>%s</CreateTime>
	        <MsgType><![CDATA[%s]]></MsgType>
	        <Content><![CDATA[%s]]></Content>
	        <FuncFlag>0</FuncFlag>
	        </xml>";
	        return sprintf($textTpl, $requestMsg->ToUserName, $requestMsg->FromUserName, time(), MsgType::$TEXT, $contentMsg);
		}
		
		//回复图文消息
		public static function responseNews($requestMsg, $newsArr){
			$newsTpl = "<xml>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<ArticleCount>%s</ArticleCount>
			<Articles>%s</Articles>
			</xml>";
			
			$articleTpl = "<item>
			<Title><![CDATA[%s]]></Title>
			<Description><![CDATA[%s]]></Description>
			<PicUrl><![CDATA[%s]]></PicUrl>
			<Url><![CDATA[%s]]></Url>
			</item>";
			
			$articleStr = "";
			foreach ($newsArr as $item){
			    $articleStr .= sprintf($articleTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
			}
			return sprintf($newsTpl, $requestMsg->ToUserName, $requestMsg->FromUserName, time(), MsgType::$News, count($newsArr), $articleStr);
		}
		
	}
?>