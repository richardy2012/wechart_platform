
<div style="height:10px;"></div>
<ul class="nav-ul">
	<li>
		<span class="title">开发者公众账号</span>
	</li>
	<li <?php if($CUR_NAE == 'urltoken') echo 'class="cur-nav"' ?> ><a href="<?php echo $CONTEXT_PATH?>/wxcms/urltoken.php">
		<span>URL 和  Token</span>
	</a></li>
	<li <?php if($CUR_NAE == 'msgtext') echo 'class="cur-nav"' ?> ><a href="<?php echo $CONTEXT_PATH?>/wxcms/msgtextList.php">
		<span>文本消息</span>
	</a></li>
	<li <?php if($CUR_NAE == 'msgnews') echo 'class="cur-nav"' ?> ><a href="<?php echo $CONTEXT_PATH?>/wxcms/msgnewsList.php">
		<span>图文消息</span>
	</a></li>
	<li <?php if($CUR_NAE == 'menu') echo 'class="cur-nav"' ?> ><a href="<?php echo $CONTEXT_PATH?>/wxcms/menuGroupList.php">
		<span>菜单管理</span>
	</a></li>
	<li <?php if($CUR_NAE == 'fans') echo 'class="cur-nav"' ?> ><a href="<?php echo $CONTEXT_PATH?>/wxcms/fansList.php">
		<span>粉丝管理</span>
	</a></li>
</ul>



