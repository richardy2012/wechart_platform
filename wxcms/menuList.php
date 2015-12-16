<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'menu'; ?>
		<?php include "../static/res.php" ?>
		
		<script type="text/javascript">
			function doAdd(){
				var gid = $('#id_gid').val();
				if(!rf.isEmpty(gid)){
					window.location.href='<?php echo $CONTEXT_PATH;?>/wxcms/menuInput.php?gid='+gid;
				}else{
					alert('请先保存菜单组名称');
				}
			}
			function doSaveGroupMenu(){
				var name = $('#id_name').val();
				if(!rf.isEmpty(name)){
					$('#id_menu_group_form').submit();
				}else{
					alert('菜单组名称不能为空');
				}
			}
			function doDelete(id){
				var gid = $('#id_gid').val();
				if(confirm("确定删除?")){
					window.location.href='<?php echo $CONTEXT_PATH ?>/wxcms/menuDelete.php?id='+id+'&gid='+gid;
				}
			}
			function doBack(){
				window.location.href='${s.base}/wxcms/accountMenuGroup/paginationEntity.html';
			}
		</script>
	</head>
	
	<?php 
		if(isset($_GET['gid']) && $_GET['gid'] != ''){
			$menuGroup = new AccountMenuGroup();
			$menuGroup = $menuGroup->queryById($_GET['gid']);
			
			$menu = new AccountMenu();
			$sql = "select t1.*,t2.name as parentName 
			from t_wxcms_account_menu t1 left join t_wxcms_account_menu t2
			on t1.parentId = t2.id where t1.gid = ".$_GET['gid'];
			$menuList = $menu->queryBySql($sql);
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
					<span class="title">菜单管理</span>
				</div>
				<div class="block-content-description">
					<span>
						请先填写 <span style="color:#555;">菜单组名称</span> 并保存 ，再添加菜单
					</span>
				</div>
				<div class="block-content-content">
					<form id="id_menu_group_form" action="<?php echo $CONTEXT_PATH.'/wxcms/menuGroupSave.php'?>" method="post" >
						<input id="id_gid" name="gid" type="hidden" value="<?php if(isset($menuGroup)) echo $menuGroup['id']; ?>"/>
						<ul>
							<li>
								<label style="width: 100px;">菜单组名称 </label>
								<input id="id_name" type="text" name="name" maxlength="20" value="<?php if(isset($menuGroup)) echo $menuGroup['name']; ?>">
								<span style="color:red">*</span>
								<input class="btn" onclick="doSaveGroupMenu();" type="button" value="保 存"/>
							</li>
						</ul>
					</form>
					<table class="fm-table" style="margin-top:10px;">
						<thead>
							<tr>
								<td rowspan="2" style="width: 100px;">名称</td>
								<td colspan="3" >消息类型</td>
								<td rowspan="2" style="width: 100px;">一级菜单</td>
								<td rowspan="2" style="width: 50px;">顺序</td>
								<td rowspan="2" style="width: 120px;">
									<input class="btn" onclick="doAdd();" type="button" value="添 加"/>
								</td>
							</tr>
							
							<tr>
								<td style="width:150px;">关键字消息</td>
								<td style="width:150px;">指定消息</td>
								<td>链接消息</td>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								if(isset($menuList)){
									for ($i= 0; $i < count($menuList); $i++){
										$item = $menuList[$i];
										if($i % 2 == 0){
											echo '<tr>';
										}else{
											echo '<tr class="even-tr">';
										}
										echo '<td>'.$item['name'].'</td>';
										echo '<td>'.$item['inputCode'].'</td>';
										echo '<td>'.$item['msgId'].'</td>';
										echo '<td>'.$item['url'].'</td>';
										echo '<td>'.$item['parentName'].'</td>';
										echo '<td>'.$item['sort'].'</td>';
										echo '<td>
										<a href="javascript:void(0);" onclick="doDelete(\''.$item['id'].'\')">删除</a>
										</td>';
										echo '</tr>';
									}
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