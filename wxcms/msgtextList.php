<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'msgtext'; ?>
		<?php include "../static/res.php" ?>
		
		<script type="text/javascript">
			function doDelete(id,baseId){
				if(confirm("确定删除?")){
					window.location.href='<?php echo $CONTEXT_PATH ; ?>/wxcms/msgtextDelete.php?id='+id+'&baseId='+baseId
				}
			}
		</script>
	</head>
	
	<?php 
		$msgText = new MsgText();
		$sql = ' select b.id as baseId, b.inputCode,t.content ,t.id as id from  '.
		' t_wxcms_msg_base b,t_wxcms_msg_text t '.
		' where t.base_id = b.id';
		$msgTextList = $msgText->queryBySql($sql);
	?>
	
	<body class="bg">
		<?php include "../static/top.php" ?>
		
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
			<div class="block-content" >
				<div class="block-content-nav">
					<span class="title">文本消息</span>
				</div>
				<div class="block-content-description">
					<span>
						文本消息管理
					</span>
				</div>
				<div class="block-content-content">
					<table class="fm-table">
						<thead>
							<tr >
								<td style="width: 150px;">关键词</td>
								<td>消息描述</td>
								<td style="width: 250px;">
									<input class="btn" onclick="window.location.href='<?php echo $CONTEXT_PATH;?>/wxcms/msgtextInput.php'" type="button" value="添 加"/>
								</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								for ($i= 0; $i < count($msgTextList); $i++){
									$item = $msgTextList[$i];
									if($i % 2 == 0){
										echo '<tr>';
									}else{
										echo '<tr class="even-tr">';
									}
									echo '<td>'.$item['inputCode'].'</td>';
									echo '<td>'.$item['content'].'</td>';
									echo '<td>
									<a href="javascript:void(0);" onclick="doDelete(\''.$item['id'].'\',\''.$item['baseId'].'\')">删除</a>&nbsp;&nbsp;
									<a href="' . $CONTEXT_PATH . '/wxcms/msgtextInput.php?id='.$item['id'].'" >修改</a>
									</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="clearfloat"></div>
		</div>
		<?php include "../static/footer.php" ?>
	</body>
</html>