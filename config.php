<?php

//时区
date_default_timezone_set('Asia/Shanghai');

//base path 和 base url
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
define('BASE_URL','http://'.$_SERVER ['HTTP_HOST']);

//设置Title
define('TITLE','工长大本营App管理后台');

//设置数据库
define('DB_NAME','gongzhang_db');

?>
