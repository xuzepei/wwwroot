<?php

//基本配置
require_once './config.php';

//设置Session
require_once BASE_PATH.'/tool/tool.php';
Tool::start_session(60*60);

//打印出错信息设置
require_once BASE_PATH.'/tool/error_log_setting.php';

$controller_name=$_GET['c'];
$method=$_GET['m'];

//控制器选用
if(!isset($controller_name) || !preg_match('/^[a-zA-Z]+$/',$controller_name))
{
    $controller_name = 'Index';
}

$controller_name = ucfirst($controller_name)."Controller";
$controller_filepath = BASE_PATH."/mvc/controller/".$controller_name.".php";
if(!file_exists($controller_filepath))
{
    $controller_name = 'IndexController';
}

include_once(BASE_PATH."/mvc/controller/".$controller_name.".php");
if(class_exists($controller_name))
{
    $controller = new $controller_name();
}

//控制器方法选用
if(!isset($controller))
    exit();

if(!isset($method) || !preg_match('/^[_a-zA-Z]+$/',$method) ||!method_exists($controller,$method))
{
    $controller->invoke();
}
else {
    $controller->$method();
}





?>

