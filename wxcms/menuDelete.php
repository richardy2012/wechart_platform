<?php 
	include_once '../common/include-file.php';
	$id = $_GET['id'];
	$gid = $_GET['gid'];
	
	$accountMenu =  new AccountMenu();
	$accountMenu->delete(" id = " . $id);
	
	header("Location:" . $CONTEXT_PATH . "/wxcms/menuList.php?gid=".$gid);
?>