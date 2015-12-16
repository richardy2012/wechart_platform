<?php 
	include_once '../common/include-file.php';
	$inputCode = $_POST['inputCode'];
	$id = $_POST['id'];
	$baseId = $_POST['baseId'];
	if(isset($id) && $id != ''){//更新
		//msgBase
		$msgBase =  new MsgBase();
		$baseData = Array(
			'id'=>$baseId,
			'inputCode'=>$_POST['inputCode']
		);
		$msgBase->updateById($baseData);
		//msgText
		$msgText =  new MsgText();
		$data = Array(
			'id'=>$id,
			'content'=>$_POST['content']
		);
		$msgText->updateById($data);
	}else{
		//msgBase
		$msgBase =  new MsgBase();
		$baseData = Array(
			'msgType'=>'text',
			'inputCode'=>$_POST['inputCode'],
			'createTime'=>date('Y-m-d')
		);
		$baseId = $msgBase->insert($baseData);
		
		//msgText
		$msgText =  new MsgText();
		$data = Array(
			'base_id'=>$baseId,
			'content'=>$_POST['content']
		);
		$msgText->insert($data);
	}
	header("Location:".$CONTEXT_PATH."/wxcms/msgtextList.php");		
?>