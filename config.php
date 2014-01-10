<?php

//时区
date_default_timezone_set('Asia/Shanghai');

//base path 和 base url
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
$base_url = 'http://'.$_SERVER ['HTTP_HOST'];

?>
