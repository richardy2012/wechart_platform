
<?php
	include '../common/include-file.php';
	
	$msgBase =  new MsgBase();
	$baseData = Array(
		'msgType'=>'text',
		'inputCode'=>'123456',
		'createTime'=>date('Y-m-d')
	);
	//$baseId = $msgBase->insert($baseData);
	
	$msgBase->delete('id = 4 ');
	
?>

