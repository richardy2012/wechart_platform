<?php 

	include_once '../common/include-file.php';
	$id = $_GET['id'];
	
	$menuGroup =  new AccountMenuGroup();
	$menuGroup->delete(" id = " . $id);
	
	header("Location:".$CONTEXT_PATH."/wxcms/menuGroupList.php");
	
?>