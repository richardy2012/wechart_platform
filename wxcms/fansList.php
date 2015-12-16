<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'fans'; ?>
		
		<?php include "../static/res.php" ?>
		<script type="text/javascript">
			function doSync(){
				if(confirm("确定同步?")){
					window.location.href='${s.base}/wxapi/syncAccountFansList.html';
				}
			}
		</script>
	</head>
	
	<?php 
		$accountFans = new AccountFans();
		$fansList = $accountFans->query();
	?>
	
	<body class="bg">
		<?php include "../static/top.php" ?>
		
		<div class="content">
			<div class="block-nav">
				<?php include "../static/nav.php" ?>
			</div>
			<div class="block-content" >
				
				<div class="block-content-nav">
					<span class="title">粉丝管理</span>
				</div>
				
				<div class="block-content-description">
					<span>
						管理、同步微信公众账号的粉丝（认证公众号）
					</span>
				</div>
				
				<div class="block-content-content">
					<div class="optbar">
						<input class="btn" onclick="doSync();" type="button" value="同步粉丝"/>
					</div>
					<table class="fm-table">
						<thead>
							<tr style="height: 45px;">
								<td style="width:100px;">昵称</td>
								<td style="width:50px;">性别</td>
								<td style="width:100px;">省-市</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								for ($i= 0; $i < count($fansList); $i++){
									$item = $fansList[$i];
									if($i % 2 == 0){
										echo '<tr style="height:40px;">';
									}else{
										echo '<tr style="height:40px;background-color:#f9f9f9;">';
									}
									echo '<td>'.$item['nickname'].'</td>';
									if($item['gender'] == 1){
										echo '<td>男</td>';
									}else{
										echo '<td>女</td>';
									}
									echo '<td>'.$item['province'].'-'.$item['city'].'</td>';
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