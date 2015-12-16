<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'urltoken'; ?>
		
		<?php include "../static/res.php" ?>
		
		<script type="text/javascript">
			function dosubmit(){
				var account = $('#id_account').val();
				account = account.replace(/(\s*$)/g, '');
				if(account == ''){
					alert('请填写微信公众号');
					return false;
				}else{
					return true;
				}
			}
			function getUrl(){
				var account = $('#id_account').val();
				account = account.replace(/(\s*$)/g, '');
				if(account == ''){
					alert('请填写微信公众号ID');
					return false;
				}else{
					$('#id_url').val('url');
					$('#id_tocken').val('tocken');
				}
			}
		</script>
	</head>
	
	<?php 
	
		if($_SERVER['REQUEST_METHOD'] == 'POST') {//POST 请求
			$account = new Account();
			
			$data = Array(
				'account' => $_POST['account'],
				'token' => $_POST['token'],
				'appid' => $_POST['appid'],
				'appsecret' => $_POST['appsecret'],
				'msgCount' => $_POST['msgCount'],
			);
			
			$url = 'http://' . $_SERVER['HTTP_HOST'] . $CONTEXT_PATH . '/wxapi/message.php';
			$data['url'] = $url;
			if(isset($_POST['id']) && $_POST['id'] != ''){//更新
				$data['id'] = $_POST['id'];
				$account->updateById($data);
			}else{//添加
				$account->insert($data);
			}
			$account = $account->getSingleAccount();
			$successflag = true;
			
		}else{//GET 请求，验证URL TOKEN
			$account = new Account();
			$account = $account->getSingleAccount();
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
					<span class="title">URL 和 Token</span>
				</div>
				
				<div class="block-content-description">
					<span>填写 <span style="color:#555;">公众号</span>，点击 <span style="color:#555;">保存</span> 按钮，
					系统将自动生成 URL 和 Token 。将它们填写到公众平台 
					<span style="color:#555;">开发者中心</span> 中，公众账号即可升级成为开发者账号
					</span>
				</div>
				
				<div class="block-content-content">
					<form class="fm-form" action="" method="post" onsubmit="return dosubmit();">
						<input type="hidden" name="id" value="<?php echo $account['id']; ?>"/>
						<ul>
							<li>
								<label>公众号 </label>
								<input id="id_account" name="account" type="text" value="<?php echo $account['account']; ?>"/>
								<span style="color: red;">*</span>&nbsp;<span class="gray-span">英文或数字</span>
							</li>
							<li>
								<label>URL </label>
								<input id="id_url" readonly="readonly" name="url" style="width:500px;" type="text" value="<?php echo $account['url']; ?>"/>
							</li>
							<li>
								<label>Token </label>
								<input id="id_tocken" name="token" style="width:500px;" type="text" value="<?php echo $account['token']; ?>"/>
							</li>
							<li>
								<label>AppId </label>
								<input name="appid" style="width:500px;" type="text" value="<?php echo $account['appid']; ?>"/>
							</li>
							<li>
								<label>AppSecret </label>
								<input name="appsecret" style="width:500px;" type="text" value="<?php echo $account['appsecret']; ?>"/>
							</li>
							<li>
								<label>消息条数 </label>
								<select name="msgCount">
									<option value="1" <?php if($account['msgCount']==1) echo 'selected = "selected"' ?> >1条</option>
									<option value="2" <?php if($account['msgCount']==2) echo 'selected = "selected"' ?> >2条</option>
									<option value="3" <?php if($account['msgCount']==3) echo 'selected = "selected"' ?> >3条</option>
									<option value="4" <?php if($account['msgCount']==4) echo 'selected = "selected"' ?> >4条</option>
									<option value="5" <?php if($account['msgCount']==5) echo 'selected = "selected"' ?> >5条</option>
									<option value="6" <?php if($account['msgCount']==6) echo 'selected = "selected"' ?> >6条</option>
									<option value="7" <?php if($account['msgCount']==7) echo 'selected = "selected"' ?> >7条</option>
									<option value="8" <?php if($account['msgCount']==8) echo 'selected = "selected"' ?> >8条</option>
								</select>
								<span class="gray-span"> 回复图文消息条数</span>
							</li>
						</ul>
						
						<div style="margin-left:75px;margin-top: 20px;">
							<input class="btn" type="submit" value="保 存"/>
							<?php if(isset($successflag)) {
								echo '<span style="margin-left:10px;color:#44b549;">已成功获取URL 和 Token</span>';
							}
							?> 
						</div>
					</form>
				</div>
				
			</div>
			
			<div class="clearfloat"></div>
		</div>
		
		<?php include "../static/footer.php" ?>

	</body>
	
</html>