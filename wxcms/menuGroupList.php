<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'menu'; ?>
		<?php include "../static/res.php" ?>
		<script type="text/javascript">
			function doDelete(id){
				if(confirm("确定删除?")){
					window.location.href='<?php echo $CONTEXT_PATH;?>/wxcms/menuGroupDelete.php?id='+id;
				}
			}
			function doPublish(){
				var gid = $('input:radio[name=radio_name]:checked').val();
				if(gid != null && gid != 'undefined'){
					if(confirm("确定生成微信账号菜单?")){
						window.location.href='<?php echo $CONTEXT_PATH;?>/wxapi/publishMenu.php?gid='+gid;
					}
				}else{
					alert("请选择菜单组");
				}
			}
			function doCancel(){
				if(confirm("确定删除微信账号菜单?")){
					window.location.href='<?php echo $CONTEXT_PATH;?>/wxapi/deleteMenu.php'; 
				}
			}
		</script>
	</head>
	
	<?php 
		$menuGroup = new AccountMenuGroup();
		$menuGroupList = $menuGroup->query();
	?>

	<body class="bg">
		<?php include "../static/top.php" ?>
		
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
		
			<div class="block-content" >
				<div class="block-content-nav">
					<span class="title">菜单管理</span>
				</div>
				
				<div class="block-content-description">
					<span>
						每个账号可以创建多套菜单，根据不同情况选择不同的菜单
					</span>
				</div>
				
				<div class="block-content-content">
					<form id="id_fm_form" method="post" action="<?php echo $CONTEXT_PATH;?>/wxcms/menuList.php">
						<table class="fm-table">
							<thead>
								<tr>
									<td style="width:10px;"></td>
									<td style="width:100px;">菜单组名称</td>
									<td style="width:100px;">是否在用</td>
									<td style="width:100px;">
										<input class="btn" onclick="window.location.href='<?php echo $CONTEXT_PATH;?>/wxcms/menuList.php'" type="button" value="添 加"/>
									</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									for ($i= 0; $i < count($menuGroupList); $i++){
										$item = $menuGroupList[$i];
										if($i % 2 == 0){
											echo '<tr>';
										}else{
											echo '<tr class="even-tr">';
										}
										echo '<td style="width:10px;"><input type="radio" name="radio_name" value="'.$item['id'].'"/></td>';
										echo '<td>'.$item['name'].'</td>';
										if($item['enable'] == 1){
											echo '<td><span style="color:green;">是</span></td>';
										}else{
											echo '<td>否</td>';
										}
										echo '<td>
										<a href="javascript:void(0);" onclick="doDelete('.$item['id'].')">删除</a>&nbsp;&nbsp;
										<a href="'.$CONTEXT_PATH.'/wxcms/menuList.php?gid='.$item['id'].'" >修改</a>
										</td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
						<div class="optbar" style="text-align:left;margin-top:20px;margin-left:-10px;">
							<input class="btn" style="width:160px;" onclick="doPublish();" type="button" value="生成微信账号菜单"/>
							<input class="btn" style="width:160px;" onclick="doCancel();" type="button" value="删除微信账号菜单"/>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfloat"></div>
		</div>
		<?php include "../static/footer.php" ?>
	</body>
</html>