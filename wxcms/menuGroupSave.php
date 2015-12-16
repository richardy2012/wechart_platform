<?php
	include_once '../common/include-file.php';
	$id = '';
	if(isset($_POST['gid']) && $_POST['gid'] != ''){
		$id = $_POST['gid'];
		$menuGroup = new AccountMenuGroup();
		$data = Array(
			'id'=>$id,
			'name' => $_POST['name'],
		);
		$menuGroup->updateById($data);
	}else{
		$menuGroup = new AccountMenuGroup();
		$data = Array(
			'name' => $_POST['name'],
		);
		$id = $menuGroup->insert($data);
	}
	header("Location:". $CONTEXT_PATH ."/wxcms/menuList.php?gid=".$id);
?>