<?php 

	include_once '../common/include-file.php';
	
	$id = $_GET['id'];
	$baseId = $_GET['baseId'];
	
	$msgBase =  new MsgBase();
	$msgBase->delete(" id = " . $baseId);
	
	$msgNews =  new MsgNews();
	$msgNews->delete(" id = " . $id);
	
	header("Location:". $CONTEXT_PATH ."/wxcms/msgnewsList.php");
	
?>