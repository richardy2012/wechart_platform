<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width,user-scalable=no" name="viewport">
	</head>
	
	<?php 
		include_once '../common/include-file.php';
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$sql = ' select b.id as baseId, b.inputCode, t.*  from  '.
			' t_wxcms_msg_base b,t_wxcms_msg_news t '.
			' where t.base_id = b.id and t.id = ' . $_GET['id'];
			
			$msgNews = new MsgNews();
			$rst = $msgNews->queryBySql($sql);
			if(isset($rst) && count($rst) > 0){
				$msgNews = $rst[0];
			}
		}
	?>
	
	<body style="margin: 0px;padding: 0px;">
		<div style="padding:0px 10px;">
			<div style="font-weight:bold;font-size:18px;margin-top:10px;">
			<?php 
				if(isset($msgNews) && isset($msgNews['title'])){
					echo $msgNews['title'];
				}
			?>
			</div>
		
			<div style="margin:20px 0px;">
				<?php 
					if(isset($msgNews) && isset($msgNews['picPath'])  && $msgNews['showPic'] == 1){
						echo '<img src="' . $msgNews['picPath'] . '" style="width:100%;border:none;">';
					}
				?>
			</div>
			
			<div>
				<?php 
					if(isset($msgNews) && isset($msgNews['description'])){
						echo $msgNews['description'];
					}
				?>
			</div>
		</div>
	</body>
</html>