<?php
ob_start();

include_once '../common/config.php';
include_once '../common/Log.class.php';
include_once '../common/utils.php';

//core
include_once '../core/model.php';

//初始化
if(!isset(MySql::$config)){
	MySql::$config = $CONFIG['db'];
}

//项目上下文：项目名称
$CONTEXT_PATH = '/phpweixin';
?>