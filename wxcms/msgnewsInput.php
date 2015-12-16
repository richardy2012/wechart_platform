<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'msgnews'; ?>
		<?php include "../static/res.php" ?>
		<script type="text/javascript" >
			var editor = simpleKindeditor("description");
		</script>
	</head>
	
	<?php 
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
	
	<body class="bg">
		<?php include "../static/top.php" ?>
		
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
			<div class="block-content" >
				
				<div class="block-content-nav">
					<span class="title">图文消息 添加/修改</span>
				</div>
				
				<div class="block-content-description">
					<span>
						如果 <span style="color:#555;">关键字</span> 为 <span style="color:#555;">subscribe</span> ，那么此消息为订阅消息 
					</span>
				</div>
				
				<div class="block-content-content">
					<form class="fm-form" method="post" action="<?php echo $CONTEXT_PATH . '/wxcms/msgnewsInputPost.php'; ?>" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php if(isset($msgNews)) echo $msgNews['id']; ?>"/>
						<input type="hidden" name="baseId" value="<?php if(isset($msgNews)) echo $msgNews['baseId']; ?>"/>
						
						<ul>
							<li>
								<label>关键字 </label>
								<input name="inputCode" type="text" value="<?php if(isset($msgNews)) echo $msgNews['inputCode']; ?>"/>
							</li>
							<li>
								<label>作者 </label>
								<input name="author" type="text" value="<?php if(isset($msgNews)) echo $msgNews['author']; ?>"/>
							</li>
							<li>
								<label>标题 </label>
								<input name="title" type="text" style="width:452px;" value="<?php if(isset($msgNews)) echo $msgNews['title']; ?>"/>
							</li>
							<li>
								<label>简介 </label>
							</li>
							<li style="margin-top:-15px;">
								<label></label>
								<textarea name="brief" rows="3" cols="60" style="width:452px;"><?php if(isset($msgNews)) echo $msgNews['brief']; ?></textarea>
								<span class="helptext">长度 &lt; 100 字</span>
							</li>
							<li>
								<label>封面图片 </label>
								<input type="file" name="imgFile"/>
							</li>
							<li>
								<label> </label>
								<label><input name="showPic" <?php if(isset($msgNews) && $msgNews['showPic'] == 1) echo 'checked="checked"'; ?> value="1" type="checkbox" style="vertical-align:middle;margin-right:5px;"/><span>显示图片</span></label>
							</li>
							
							<li>
								<label></label>
								<?php if(isset($msgNews) && isset($msgNews['picPath'])){
									echo '<img src="'.$msgNews['picPath'].'" alt="" style="border: none;max-width:300px;height:100px;"/>';
								}									
								?>
							</li>
							<li>
								<label>内容 </label>
								<span style="color:#ccc"> 如果填写了下方的 <span style="color:#555;">原文链接</span> ，内容可以不填写，微信中点击消息，自动跳转到原文链接</span>
							</li>
							<li style="margin-left:86px;">
								<textarea name="description" style="width:452px;height:300px;visibility:hidden;"><?php if(isset($msgNews)) echo $msgNews['description']; ?></textarea>
							</li>
							<li>
								<label>原文链接 </label>
								<input type="text" name="fromurl" value="<?php if(isset($msgNews)) echo $msgNews['fromurl']; ?>" style="width:452px;"/>
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