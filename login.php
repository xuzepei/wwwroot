<!DOCTYPE html>
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

        <title>用户登录</title>

        <!-- Bootstrap core CSS -->
        <link href="./bootstrap/v3/css/bootstrap.css" rel="stylesheet">

        <!-- My CSS -->
        <link href="./css/designer_list.css" rel="stylesheet">
        
        <!-- My JS -->
        <script src="./js/login_validate.js"></script>

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
                    <a class="navbar-brand" href="#">工长大本营App管理后台</a>
                </div>
                <div class="navbar-collapse collapse">
                <p class="navbar-text pull-right">
              <?php
require_once './config.php';
echo '<a href='.'"'.$base_url.'/register.php'.'"'.'class="navbar-link">注册</a>';
                    ?>
            </p>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        
        <!-- Wrap all page content here -->
        <div id="wrap">
            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1>用户登录</h1>
                </div>
                <p>

                    <!-- list -->
                    <?php
require_once './config.php';
require_once BASE_PATH.'/error_log_setting.php';
require_once BASE_PATH.'/db/medoo.php';
$database = new medoo('gongzhang_db');

$username = $_POST['username'];
$password = $_POST['password'];
$user_tb = "user_tb";


$current_date = date('Y-m-d H:i:s',time());

if(!empty($username))
{ 
    $sql = 'select * from '.$user_tb.' where username = "'.$username.'" && '.'password = "'.$password.'"';
    $result = $database->select_by_sql($sql);
    
    //var_dump($result);
    //var_dump($database->error());
    
    $msg = '';
    $logined = false;
    $by_type = 'username';
    if($result != false && count($result,0))
    {
        $msg = 'Can login by username!';
        $logined = true;
    }
    else
    {
        $by_type = 'email';
        $sql = 'select * from '.$user_tb.' where email = "'.$username.'" && '.'password = "'.$password.'"';
        $result = $database->select_by_sql($sql);
        
        if($result != false && count($result,0))
        {
            $msg = 'Can login by email!';
            $logined = true;
        }
    }
    
    $msg = 'Can not login!';
    
    if($logined)
    {
        // 更新用户登录信息
        $ip = $_SERVER['REMOTE_ADDR']; // 获取客户端的IP
        $sql = 'update '.$user_tb.' set login_times = login_times + 1, last_login_time = "'.$current_date.'", login_ip = "'.$ip.'" where '.$by_type.' = "'.$username.'"';
        //echo $sql;
        $result = $database->exec($sql);
        //echo 'result:'.$result;
        //var_dump($database->error());
    }
    
}
                    ?>
                    
                    
<!--                <form class="add_designer_form" name="add_designer" method="post" action="add_designer.php">
                  <input type="submit" name="add_designer_button" id="add_designer_button" value="添加">
                </form>-->

<form name="login_form" method="post" action="login.php" onsubmit="return validate();">
<table width="330" border="0" align="center" cellpadding="5" bgcolor= "#eeeeee">
<tr>
    <td>用户名/邮箱：</td>
    <td><input name="username" type="text" id="username"> </td>
</tr>
<tr>
    <td>密码：</td>
    <td><input name="password" type="password" id="password"></td>
</tr>
<tr>
    <td colspan="2" align="center">
      <input type="submit" name="submit" value="提交">
</tr>
</table>
</form>

                
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


