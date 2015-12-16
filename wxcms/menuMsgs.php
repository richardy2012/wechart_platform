<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php $CUR_NAE = 'menu'; ?>
		<?php include "../static/res.php" ?>
		<script type="text/javascript">
			function showMsg(type){
				if(type == '1'){//news
					$('#id_msgtype').val('news');
					$('#id_news_msg').css('display','block');
					$('#id_text_msg').css('display','none');
					
					$('#id_news_span').attr('class','btn');
					$('#id_text_span').attr('class','gray-btn');
				}else{
					$('#id_msgtype').val('text');
					$('#id_news_msg').css('display','none');
					$('#id_text_msg').css('display','block');
					
					$('#id_text_span').attr('class','btn');
					$('#id_news_span').attr('class','gray-btn');
				}
			}
		</script>
	</head>
	<?php 
		
		$msgNews = new MsgNews();
		$sql = 'select b.id as baseId, b.inputCode,t.title,t.id as id from  
				t_wxcms_msg_base b,t_wxcms_msg_news t 
				where t.base_id = b.id';
		$msgNewsList = $msgNews->queryBySql($sql);
		
		$msgText = new MsgText();
		$sql = 'select b.id as baseId, b.inputCode,t.content ,t.id as id from 
				t_wxcms_msg_base b,t_wxcms_msg_text t 
				where t.base_id = b.id';
		$msgTextList = $msgText->queryBySql($sql);
	?>
	
	<body>
		<div style="width:90%;">
		
			<div style="text-align:left;">
				<input type="hidden" id="id_msgtype" name="msgtype" value="news"/>
				<span id="id_news_span" class="btn" style="width:150px;height:30px;text-align:center;" onclick="showMsg('1')" >图文消息</span>
				<span id="id_text_span" class="gray-btn" style="width:150px;height:30px;text-align:center;" onclick="showMsg('2')" >文本消息</span>
			</div>
			
			<div style="text-align:left;margin-top:20px;">
				<div id="id_news_msg">
					<div>
						<table class="fm-table">
						<thead>
							<tr style="height: 45px;">
								<td style="width: 100px;">图文消息</td>
								<td style="width: 100px;">ID</td>
								<td>标题</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								for ($i= 0; $i < count($msgNewsList); $i++){
									$item = $msgNewsList[$i];
									if($i % 2 == 0){
										echo '<tr style="height:40px;">';
									}else{
										echo '<tr style="height:40px;background-color:#f9f9f9;">';
									}
									echo '<td><input type="checkbox" value="'.$item['baseId'].'" name="checkname"/></td>';
									echo '<td>'.$item['baseId'].'</td>';
									echo '<td>'.$item['title'].'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
					</div>
				</div>
				<div id="id_text_msg" style="display:none;">
					<div>
						<table class="fm-table">
							<thead>
								<tr style="height: 45px;">
									<td style="width: 100px;">文本消息</td>
									<td style="width: 100px;">ID</td>
									<td>描述</td>
								</tr>
							</thead>
							<tbody>
								<?php 
									for ($i= 0; $i < count($msgTextList); $i++){
										$item = $msgTextList[$i];
										if($i % 2 == 0){
											echo '<tr style="height:40px;">';
										}else{
											echo '<tr style="height:40px;background-color:#f9f9f9;">';
										}
										echo '<td><input type="radio" value="'.$item['baseId'].'" name="radioname"/></td>';
										echo '<td>'.$item['baseId'].'</td>';
										echo '<td>'.$item['content'].'</td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="clearfloat"></div>
		</div>
	</body>
</html>