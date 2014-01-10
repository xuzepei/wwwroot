<!DOCTYPE html>
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

        <title>用户注册</title>

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
                    <a class="navbar-brand" href="#">工长大本营App管理后台</a>
                </div>
                <div class="navbar-collapse collapse">
                    <p class="navbar-text pull-right">
                                  <?php
require_once './config.php';
echo '<a href='.'"'.$base_url.'/login.php'.'"'.'class="navbar-link">登录</a>';
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
                    <h1>用户注册</h1>
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
$repeat_password = $_POST['repeat_password'];
$email = $_POST['email'];
$user_tb = "user_tb";


$current_date = date('Y-m-d H:i:s',time());

if(!empty($email))
{
    $result = $database->select($user_tb, "*", ["email" => $email]);
    if(count($result,0))
    {
        echo 'is existed';
    }
    else
    {
        echo 'insert';
        $last_user_id = $database->insert($user_tb, [
	"username" => $username,
	"password" => $password,
        "email" => $email,
        "regist_date" => $current_date,
]);
        echo $last_user_id;
    }
}
                    ?>
                    
                    
<!--                <form class="add_designer_form" name="add_designer" method="post" action="add_designer.php">
                  <input type="submit" name="add_designer_button" id="add_designer_button" value="添加">
                </form>-->

<form name="register_form" method="post" action="register.php" onsubmit="return validate();">
<table width="330" border="0" align="center" cellpadding="5" bgcolor= "#eeeeee">
<tr>
    <td>用户名：</td>
    <td><input name="username" type="text" id="username"> </td>
</tr>
<tr>
    <td>密码：</td>
    <td><input name="password" type="password" id="password"></td>
</tr>
<tr>
    <td>重复密码：</td>
    <td><input name="repeat_password" type="password" id="repeat_password"></td>
</tr>
<tr>
    <td>Email:</td>
    <td><input name="email" type="text" id="email"></td>
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

