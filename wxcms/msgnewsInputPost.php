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
		
		//msgNews
		//上传图片
		$picPath = '';
		$uprst = uploadImg("imgFile");
		if($uprst['flag']){
			$picPath = $uprst['imgUrl'];
		}
		
		$msgNews =  new MsgNews();
		$showPic = 0;
		if(!empty($_POST['showPic'])){
			$showPic = 1;
		}
		$data = Array(
			'id'=>$id,
			'author'=>$_POST['author'],
			'title'=>$_POST['title'],
			'brief'=>$_POST['brief'],
			'showpic'=>$showPic,
			'description'=>$_POST['description'],
			'fromurl'=>$_POST['fromurl'],
		);
		if(isset($picPath) && !empty($picPath)){
			$data['picPath'] = $picPath;
		}
		$msgNews->updateById($data);
		
	}else{//添加
		//msgBase
		$msgBase =  new MsgBase();
		$baseData = Array(
			'msgType'=>'news',
			'inputCode'=>$_POST['inputCode'],
			'createTime'=>date('Y-m-d')
		);
		$baseId = $msgBase->insert($baseData);
		
		//msgNews
		//上传图片
		$picPath = '';
		$uprst = uploadImg("imgFile");
		if($uprst['flag']){
			$picPath = $uprst['imgUrl'];
		}
		
		$msgNews =  new MsgNews();
		$showPic = 0;
		if(!empty($_POST['showPic'])){
			$showPic = 1;
		}
		$data = Array(
			'base_id'=>$baseId,
			'author'=>$_POST['author'],
			'title'=>$_POST['title'],
			'brief'=>$_POST['brief'],
			'showpic'=>$showPic,
			'description'=>$_POST['description'],
			'fromurl'=>$_POST['fromurl'],
			'picPath'=>$picPath
		);
		$newsId = $msgNews->insert($data);
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $CONTEXT_PATH  . '/wxapi/newsread.php?id'.$newsId;
		$updata = Array(
			'id'=>$newsId,
			'url'=>$url
		);
		$msgNews->updateById($updata);
	}
	header("Location:". $CONTEXT_PATH  ."/wxcms/msgnewsList.php");
?>