<?php

//时区
date_default_timezone_set('Asia/Shanghai');

//base path 和 base url
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
define('BASE_URL','http://'.$_SERVER ['HTTP_HOST']);

//设置Title
define('TITLE','工长大本营App管理后台');

//设置数据库
define('DB_USERNAME','root');
define('DB_PASSWORD','123');
define('DB_HOST','127.0.0.1');
define('DB_PORT',3306);
define('DB_NAME','gongzhang_db');

//默认查询单页数量
define('PAGE_SIZE',20);
?>
