<?php 
	include_once '../common/include-file.php';
	
	$uprst = uploadImg("imgFile");

	if($uprst['flag']){
		$rst = array ('error'=>0,'url'=>$uprst['imgUrl']);
		echo json_encode($rst);
	}else{
		echo '上传图片格式错误';
	}
	
?>