<?php
	include_once '../common/include-file.php';
	include_once '../wxapi/wxconsts.php';
	include_once '../wxapi/WxApi.class.php';
	
	$wxAccount = new Account();
	$wxAccount = $wxAccount -> getSingleAccount();
	$appId = $wxAccount['appid'];
	$appSecret = $wxAccount['appsecret'];
	
	$gid = $_GET['gid'];
	$accountMenu = new AccountMenu();
	$sql = ' select * from t_wxcms_account_menu where gid = '.$gid.' order by parentId , sort ';
	$querySet = $accountMenu -> queryBySql($sql);
	
	$menuStr = prepareMenu($querySet);
	$rst = WxApi::create_menu($appId,$appSecret,$menuStr);
	if($rst -> errcode == 0){
		$wxAccountGroup = new AccountMenuGroup();
		$wxAccountGroup -> updateById(array("id"=>$gid,"enable"=>1));
		header("Location:". $CONTEXT_PATH ."/wxcms/success.php?type=1");	
	}else{
		header("Location:". $CONTEXT_PATH ."/wxcms/failure.php?type=1&errcode=".$rst->errcode);
	}
	
	function prepareMenu($querySet){
		$menuArr = array();
		$subMenuArr = array();
		foreach ($querySet as $item){
			if($item['parentId'] == 0){
				array_push($menuArr, $item);
			}else{
				if(empty($subMenuArr[$item['parentId']])){
					$subMenuArr[$item['parentId']] = array(getMenuJson($item));
				}else{
					array_push($subMenuArr[$item['parentId']], getMenuJson($item));
				}
			}
		}
		$buttonArr = array();
		foreach ($menuArr as $item){
			if(empty($subMenuArr[$item['id']])){
				array_push($buttonArr,getMenuJson($item));
			}else{
				array_push($buttonArr,array('name'=>$item['name'],'sub_button'=>$subMenuArr[$item['id']]));
			}
		}
		return json_encode(array("button" => $buttonArr));
	}
	
	function getMenuJson($item){
		$rstArr = array('name' => $item['name'],'type' => $item['mtype']);
		if($item['mtype'] == 'click'){
			if($item['eventType'] == 'fix'){
				$rstArr['key']='_fix_'.$item['msgId'];
			}else{
				if(empty($item['inputCode'])){
					$rstArr['key']='subscribe';
				}else{
					$rstArr['key']=$item['inputCode'];
				}
			}
		}else{
			$rstArr['url']=$item['url'];
		}
		return $rstArr;
	}
?>