<?php
	include_once '../common/include-file.php';
	$menu = new AccountMenu();
	$data = Array(
		'gid'=>$_POST['gid'],
		'name'=>$_POST['name'],
		'parentid'=>$_POST['parentid'],
		'sort'=>$_POST['sort'],
		'mtype'=>$_POST['mtype'],
		'eventType'=>$_POST['eventType'],
		'inputcode'=>$_POST['inputcode'],
		'gid'=>$_POST['gid'],
		'msgId'=>$_POST['msgId'],
		'url'=>$_POST['url']
	);
	$menu->insert($data);
	header("Location:". $CONTEXT_PATH ."/wxcms/menuList.php?gid=" . $_POST['gid']);	
?>