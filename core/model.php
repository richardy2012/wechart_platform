<?php 
	include_once '../core/Model.class.php';
	
	//微信账号类
	class Account extends Model{
		public function __construct() {
			parent::__construct("t_wxcms_account");
		}
		
		public function getSingleAccount(){
			$this->order(' id desc ');
			$this->limit(0, 1);
			$list = $this->query();
			if(count($list) > 0){
				return $list[0];
			}
		}
		
	}
	
	//微信消息
	class MsgBase extends Model{
		public function __construct() {
			parent::__construct("t_wxcms_msg_base");
		}
	}
	
	//微信文本消息
	class MsgText extends Model{
		public function __construct() {
			parent::__construct("t_wxcms_msg_text");
		}
	}
	
	//微信图文消息
	class MsgNews extends  Model{
		public function __construct() {
			parent::__construct("t_wxcms_msg_news");
		}
	}
	
	//微信菜单组
	class AccountMenuGroup extends  Model{
		public function __construct() {
			parent::__construct("t_wxcms_account_menu_group");
		}
	}
	
	//微信菜单
	class AccountMenu extends  Model{
		public function __construct() {
			parent::__construct("t_wxcms_account_menu");
		}
	}
	
	//微信粉丝
	class AccountFans extends  Model{
		public function __construct() {
			parent::__construct("t_wxcms_account_fans");
		}
	}
?>