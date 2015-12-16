<?php 
	include_once '../common/include-file.php';
	$id = $_GET['id'];
	$baseId = $_GET['baseId'];
	
	$msgBase =  new MsgBase();
	$msgBase->delete(" id = " . $baseId);
	
	$msgText =  new MsgText();
	$msgText->delete(" id = " . $id);
	
	header("Location:".$CONTEXT_PATH."/wxcms/msgtextList.php");
?>