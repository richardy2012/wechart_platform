<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'msgtext'; ?>
		<?php include "../static/res.php" ?>
		<script type="text/javascript">
			function dosubmit(){
				var inputCode = $('#id_inputCode').val();
				inputCode = inputCode.replace(/(\s*$)/g, '');
				if(inputCode == ''){
					alert('请填写关键字');
					return false;
				}else{
					return true;
				}
			}
		</script>
	</head>
	<?php 
		if(isset($_GET['id']) && $_GET['id'] != ''){//修改
			$sql = ' select b.id as baseId, b.inputCode,t.content ,t.id  from  '.
			' t_wxcms_msg_base b,t_wxcms_msg_text t '.
			' where t.base_id = b.id and t.id = ' . $_GET['id'];
			
			$msgText = new MsgText();
			$rst = $msgText->queryBySql($sql);
			if(isset($rst) && count($rst) > 0){
				$msgText = $rst[0];
			}
		}
	?>
	<body class="bg">
		<?php include "../static/top.php" ?>
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
			<div class="block-content" >
				<div class="block-content-nav">
					<span class="title">文本消息 添加/修改</span>
				</div>
				<div class="block-content-description">
					<span>
						如果 <span style="color:#555;">关键字 </span> 
						为 <span style="color:#555;">subscribe</span> ，那么此消息为订阅消息
					</span>
				</div>
				<div class="block-content-content">
					<form class="fm-form" action="<?php echo $CONTEXT_PATH.'/wxcms/msgtextInputPost.php'?>" method="post"  onsubmit="return dosubmit();">
						<input type="hidden" id="id" name="id" value="<?php if(isset($msgText)){echo $msgText['id'];} ?>"/>
						<input type="hidden" id="baseId" name="baseId" value="<?php if(isset($msgText)) echo $msgText['baseId']; ?>"/>
						<ul>
							<li>
								<label>关键字 </label>
								<input id="id_inputCode" name="inputCode" type="text" value="<?php if(isset($msgText)) echo $msgText['inputCode']; ?>"/>
								<span style="color: red;">*</span>
							</li>
							<li>
								<label>内容 </label>
							</li>
							<li style="margin-top:-15px;">
								<label></label>
								<textarea name="content" rows="10" cols="30"><?php if(isset($msgText)) echo $msgText['content']; ?></textarea>
							</li>
						</ul>
						<div style="margin-left:75px;margin-top: 20px;">
							<input class="btn" type="submit" value="保 存"/>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfloat"></div>
		</div>
		<?php include "../static/footer.php" ?>
	</body>
	
</html>