<?php 

require_once './tool.php';
Tool::start_session(60*60);

$title = '工长大本营App管理后台';
$head1 = '欢迎';
?>

<!DOCTYPE html>
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

        <title><?php echo $title ?></title>

        <!-- Bootstrap core CSS -->
        <link href="./bootstrap/v3/css/bootstrap.css" rel="stylesheet">

        <!-- My CSS -->
        <link href="./css/designer_list.css" rel="stylesheet">
        
        <!-- My JS -->
        <script src="./js/register_validate.js"></script>

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css"></style><style>[touch-action="none"]{ -ms-touch-action: none; touch-action: none; }[touch-action="pan-x"]{ -ms-touch-action: pan-x; touch-action: pan-x; }[touch-action="pan-y"]{ -ms-touch-action: pan-y; touch-action: pan-y; }[touch-action="scroll"],[touch-action="pan-x pan-y"],[touch-action="pan-y pan-x"]{ -ms-touch-action: pan-x pan-y; touch-action: pan-x pan-y; }</style></head>

    <body>
        <!-- navigation bar-->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    <a class="navbar-brand" href="#"><?php echo $title ?></a>
                </div>
                <div class="navbar-collapse collapse">


                    
                                        <?php

require_once './config.php';
require_once BASE_PATH.'/error_log_setting.php';

 echo '<ul class="nav navbar-nav">'.'<li><a href='.BASE_URL.'/user_info.php'.'>设计师</a></li><li><a href="#about">关于我们</a></li><li><a href="#contact">联系我们</a></li></ul><p class="navbar-text pull-right">';

if(isset($_SESSION['username']))
{
    echo '<a href='.'"'.BASE_URL.'/user_info.php'.'"'.'class="navbar-link">'.$_SESSION['username'].'</a>   |   '.'<a href='.'"'.$BASE_URL.'/register.php'.'"'.'class="navbar-link">退出</a>';
}
else
{
    echo '<a href='.'"'.$BASE_URL.'/login.php'.'"'.'class="navbar-link">登录</a>   |   '.'<a href='.'"'.$BASE_URL.'/register.php'.'"'.'class="navbar-link">注册</a>';
}
                    ?>

                    
              <!--<a href="#" class="navbar-link">登录</a> | 
              <a href="#" class="navbar-link">注册</a>-->
            </p>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        
        <!-- Wrap all page content here -->
        <div id="wrap">
            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1><?php echo $head1;?></h1>
                </div>
                <p>

                    <!-- list -->
                    <?php
//                    include_once("mvc/controller/DesignerController.php");
//                    $controller = new DesignerController();
//                    $controller->invoke();

require_once './config.php';
require_once BASE_PATH.'/error_log_setting.php';


                    ?>
                    
                    
<!--                <form class="add_designer_form" name="add_designer" method="post" action="add_designer.php">
                  <input type="submit" name="add_designer_button" id="add_designer_button" value="添加">
                </form>-->

                    <!-- footer -->
                <hr>
                <footer>
                    <p>© SanguoTech 2013</p>
                </footer>
            </div>

        </div>

    </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


</body></html>

