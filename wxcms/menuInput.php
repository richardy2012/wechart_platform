<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'menu'; ?>
		<?php include "../static/res.php" ?>
	</head>
	
	<?php 
		$gid = '';
		$gid = $_GET['gid'];
		$menu = new AccountMenu();
		$sql = 'select * from t_wxcms_account_menu where parentId = 0 and gid = ' .$gid;
		$parentMenuList = $menu->queryBySql($sql);
	?>
	
	<body class="bg">
		<?php include "../static/top.php" ?>
		
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
			<div class="block-content" >
				
				<div class="block-content-nav">
					<span class="title">菜单 添加/修改 </span>
				</div>
				
				<div class="block-content-description">
					<span>
						微信公众账号的菜单管理：可创建最多3个一级菜单，每个一级菜单下可创建最多5个二级菜单
					</span>
				</div>
				
				<div class="block-content-content">
					<form class="fm-form" action="<?php echo $CONTEXT_PATH . '/wxcms/menuInputPost.php'?>" method="post" onsubmit="return doSubmit();">
						<input type="hidden" value="<?php echo $gid ;?>" name="gid"/>
						<ul>
							<li>
								<label style="width: 100px;">名称 </label>
								<input id="id_name" type="text" name="name" value="">
								<span style="color:red">*</span>
							</li>
							<li>
								<label style="width: 100px;">一级菜单 </label>
								<select name="parentid" style="width:158px;">
									<option value="0"> -- </option>
									<#if parentMenu?? >
									<?php 
										if(isset($parentMenuList)){
											for($i=0 ; $i < count($parentMenuList) ;$i++){
												$item = $parentMenuList[$i];
												echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
											}
										}
									?>
								</select>
							</li>
							<li>
								<label style="width: 100px;">顺序 </label>
								<select name="sort" style="width:158px;">
									<option value="1" >1</option>
									<option value="2" >2</option>
									<option value="3" >3</option>
									<option value="4" >4</option>
									<option value="5" >5</option>
									<option value="6" >6</option>
									<option value="7" >7</option>
									<option value="8" >8</option>
								</select>
							</li>
							<li>
								<label style="width: 100px;">菜单类型 </label>
								<select id="id_type" name="mtype" style="width:158px;" onchange="typeChange()">
									<option value="click" >消息</option>
									<option value="view" >链接</option>
								</select>
								<span class="gray-span">消息：点击菜单时回复消息；链接：点击菜单打开链接</span>
							</li>
							
							<li id="id_msg">
								<label style="width: 100px;">消息类型 </label>
								<select id="id_event_type" name="eventType" style="margin-top: 5px;width:158px;" onchange="eventTypeChange()">
									<option value="key">关键字</option>
									<option value="fix">指定</option>
								</select>
								<br/>
								<div id="id_keymsg">
									<label style="width: 100px;">关键字 </label>
									<input type="text" name="inputcode" style="margin-top: 5px;" />
									<span class="gray-span">消息的关键字</span>
								</div>
								<div id="id_fixmsg" style="display: none;">
									<label style="width: 100px;">指定消息 </label>
									<input type="text" id="id_msgIds" name="msgId" style="margin-top: 5px;" readonly="readonly"/>
									<input type="button" value="选择" onclick="getMsgs();">
								</div>
							</li>
							
							<li id="id_view" style="display: none;">
								<label style="width: 100px;">链接URL </label>
								<input id="id_url" type="text" name="url" style="width: 400px;margin-top: 5px;" >
								<span style="color:red">*</span>
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
		
		<div id="id_msgs" class="layer">
			<iframe id="id_msgs_frame" style="width:100%;height:100%;border:none;" src="<?php echo $CONTEXT_PATH ?>/wxcms/menuMsgs.php">
	    	</iframe>
		</div>
		
		<script type="text/javascript">
			function typeChange(){
				var value = $("#id_type  option:selected").val();
				if(value == 'click'){
					$("#id_view").css("display","none")
					$("#id_msg").css("display","inline")
				}else{
					$("#id_view").css("display","inline")
					$("#id_msg").css("display","none")
				}
			}
			
			function eventTypeChange(){
				var value = $("#id_event_type  option:selected").val();
				if(value == 'key'){
					$("#id_keymsg").css("display","inline")
					$("#id_fixmsg").css("display","none")
				}else{
					$("#id_keymsg").css("display","none")
					$("#id_fixmsg").css("display","inline")
				}
			}
			
			function doSubmit(){
				var name = $("#id_name").val();
				if(name.replace(/(\s*$)/g, '') == ''){
					alert('菜单名称不能为空');
					return false;
				}
				return true;
			}
			
			function getMsgs(){
				$('#id_msgs').dialog({
					title:'选择消息',
			        width: 600,
			        height:400,
			        modal: true,
			        buttons: {
			            "确定": function() {
			            	var msgtype = $("#id_msgs_frame").contents().find('input[name="msgtype"]').val();
			            	if(msgtype == 'news'){
			            		var val = [];
			            		$("#id_msgs_frame").contents().find('input[name="checkname"]:checked').each(function(){ 
			            			val.push($(this).val())
			                    })
			            		if(val.length > 0){
				            		$("#id_msgIds").val(val.join(','));
				            	}
			            	}else{
			            		var val = $("#id_msgs_frame").contents().find('input[name="radioname"]:checked').val();
			            		if(val != undefined){
				            		$("#id_msgIds").val(val);
				            	}
			            	}
			                $(this).dialog('close');
			            }
			        }
			    });
			}
		</script>
		
		<?php include "../static/footer.php" ?>
	</body>
	
</html>