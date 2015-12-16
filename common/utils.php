<?php 
	//上传图片
	function uploadImg($fileName){
		$filetype =  $_FILES[$fileName]["type"];
		$uptypes = array("image/jpg","image/gif","image/jpeg","image/png");
		
		if(in_array($filetype, $uptypes)) {
			
	      	$filename = $_FILES[$fileName]["name"];
	      	$ext = substr(strrchr($filename, '.'), 1);
	      	
			$file_path = 'static/res/upload/'.time() . '.' . $ext; 
			move_uploaded_file($_FILES[$fileName]["tmp_name"], '../' . $file_path);
	
			$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $file_path; 
			return Array('flag'=>true,'imgUrl'=>$imgUrl);
			
		}else{
			return Array('flag'=>false);
		}
	}
?>