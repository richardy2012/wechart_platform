<?php
	include_once '../common/include-file.php';
	include_once '../core/model.php';
	include_once '../wxapi/WxApi.class.php';
	
	$wxAccount = new Account();
	$wxAccount = $wxAccount -> getSingleAccount();
	$appId = $wxAccount['appid'];
	$appSecret = $wxAccount['appsecret'];
		
	$rst = WxApi::delete_menu($appId, $appSecret);
	if($rst -> errcode == 0){
		header("Location:". $CONTEXT_PATH ."/wxcms/success.php?type=2");	
	}else{
		header("Location:". $CONTEXT_PATH ."/wxcms/failure.php?type=2&errcode=".$rst->errcode);
	}
?>