<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php include "../static/res.php" ?>
	</head>
	
	<body class="bg">
		<?php include "../static/top.php" ?>
		<?php include "../wxapi/wxconsts.php" ?>
		
		<div class="content">
			
			<div style="margin-top:50px;">
				<span style="font-size:16px;">
				<?php 
					$type = $_GET['type'];
					$errcode = $_GET['errcode'];
					if($type == 1){
						echo "创建菜单失败 ：".$ERROR_CODE[$errcode];
					}
					if($type == 2){
						echo "删除菜单失败 ：".$ERROR_CODE[$errcode];
					}
				?>
				</span>
			</div>
			
			<div class="clearfloat"></div>
		</div>
		
		<?php include "../static/footer.php" ?>
	</body>
	
</html>


