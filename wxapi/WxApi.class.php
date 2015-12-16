<?php
	class WxApi{
		//token 接口
		private static $TOKEN = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
		//创建菜单
		private static $MENU_CREATE = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s";
		//删除菜单
		private static $MENU_DELETE = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s";
		
		
		//获取token接口
		public static function getTokenUrl($appId,$appSecret){
			return sprintf(WxApi::$TOKEN, $appId, $appSecret);
		}
		
		//获取菜单创建接口
		public static function getCreateMenuUrl($token){
			return sprintf(WxApi::$MENU_CREATE, $token);
		}
		
		//获取菜单删除接口
		public static function getDeleteMenuUrl($token){
			return sprintf(WxApi::$MENU_DELETE, $token);
		}
		
		//获取token
		public static function getToken($appId, $appSecret) {
			$tockenUrl = WxApi::getTokenUrl($appId, $appSecret);
			$rstJson = WxApi::https_request($tockenUrl);
			return $rstJson -> access_token;
		}
		
		//创建菜单
		public static function create_menu($appId, $appSecret, $menuJsonStr){
			$token = WxApi::getToken($appId, $appSecret);
			$createMenuUrl = WxApi::getCreateMenuUrl($token);
			return WxApi::https_request($createMenuUrl,$menuJsonStr);
		}
		
		//删除菜单
		public static function delete_menu($appId, $appSecret){
			$token = WxApi::getToken($appId, $appSecret);
			$deleteMenuUrl = WxApi::getDeleteMenuUrl($token);
			return WxApi::https_request($deleteMenuUrl);
		}
		
		//发送http请求,返回json数据
		public static function https_request($url, $data = null){
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		    if (!empty($data)){
		        curl_setopt($curl, CURLOPT_POST, 1);
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		    }
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    $result = curl_exec($curl);
		    curl_close($curl);
		    return json_decode($result);
		}
		
	}
?>