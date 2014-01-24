<?php

class UserController {

    public function __construct()
    {
        
    }

    public function invoke()
    {
        
    }

    public function login()
    {
        $title = TITLE;
        $head1 = '用户登录';
        $css_file_array = array('/bootstrap/v3/css/bootstrap.css', '/css/login_form.css');
        $js_file_array = array('/js/login_validate.js');

        include BASE_PATH . '/mvc/view/header.php';


        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo(DB_NAME);

        $username = $_POST['username'];

        $password = $_POST['password'];
        $password_md5 = md5($password);

        $captcha = $_POST['captcha'];

        $user_tb = "user_tb";


        $current_date = date('Y-m-d H:i:s', time());


        if (!empty($username))
        {
            if (true == empty($_SESSION['captcha']) || 0 != strcasecmp($captcha, $_SESSION['captcha']))
            {
                echo '<div id="alert" class="alert alert-danger">' . '验证码错误！' . "</div>";
            }
            else
            {
                $sql = 'select * from ' . $user_tb . ' where username = "' . $username . '" && ' . 'password = "' . $password_md5 . '"';
                $result = $database->select_by_sql($sql);

                //var_dump($result);
                //var_dump($database->error());

                $msg = '';
                $logined = false;
                $by_type = 'username';
                if ($result != false && count($result, 0))
                {
                    $msg = 'Can login by username!';
                    $logined = true;
                }
                else
                {
                    $by_type = 'email';
                    $sql = 'select * from ' . $user_tb . ' where email = "' . $username . '" && ' . 'password = "' . $password_md5 . '"';
                    $result = $database->select_by_sql($sql);

                    if ($result != false && count($result, 0))
                    {
                        $msg = 'Can login by email!';
                        $logined = true;
                    }
                }

                $msg = 'Can not login!';

                if ($logined)
                {
                    //更新session
                    $_SESSION['username'] = $username;

                    // 更新用户登录信息
                    $ip = $_SERVER['REMOTE_ADDR']; // 获取客户端的IP
                    $sql = 'update ' . $user_tb . ' set login_times = login_times + 1, last_login_time = "' . $current_date . '", login_ip = "' . $ip . '" where ' . $by_type . ' = "' . $username . '"';
                    //echo $sql;
                    $result = $database->exec($sql);
                    //echo 'result:'.$result;
                    //var_dump($database->error());

                    header("Location:" . BASE_URL . "/index.php");
                }
                else
                {
                    echo '<div id="alert" class="alert alert-danger">' . '登录失败，用户名或密码错误！' . "</div>";
                }
            }
        }

        $action = BASE_URL . '?c=user&m=login';
        include BASE_PATH . '/mvc/view/login_form.php';
        include BASE_PATH . '/mvc/view/footer.php';
    }

    public function logout()
    {
        unset($_SESSION['username']);
        header("Location:" . BASE_URL . "/index.php");
    }

    private function validate($type, $value)
    {
        if (0 == strcmp($type, 'username'))
        {
            $length = strlen($value);
            if ($length >= 2 && $length <= 16)
            {
                return true;
            }
        }
        else if (0 == strcmp($type, 'email'))
        {
            $regexp = '/^[\w-]+(\.[\w]+)*@([\w-]+\.)+[a-zA-z]{2,7}$/';
            if (preg_match($regexp, $value))
            {
                return true;
            }
        }
        else if (0 == strcmp($type, 'password'))
        {
            $length = strlen($value);
            if ($length >= 6 && $length <= 16)
            {
                return true;
            }
        }

        return false;
    }

    public function register()
    {
        $title = TITLE;
        $head1 = '用户注册';

        $css_file_array = array('/bootstrap/v3/css/bootstrap.css', '/css/register_form.css');
        $js_file_array = array('/js/register_validate.js');

        include BASE_PATH . '/mvc/view/header.php';
        $register_success = false;

        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo(DB_NAME);

        $username = $_POST['username'];

        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];
        $password_md5 = md5($password);
        $repeat_password_md5 = md5($repeat_password);

        $email = $_POST['email'];

        $captcha = $_POST['captcha'];

        $user_tb = "user_tb";

        $current_date = date('Y-m-d H:i:s', time());

        if (!empty($username) && !empty($email))
        {
            if (false == $this->validate('username', $username))
            {
                echo '<div id="alert" class="alert alert-danger">' . '要求用户名的长度为2～16个字符！' . "</div>";
            }
            else if (false == $this->validate('password', $password))
            {
                echo '<div id="alert" class="alert alert-danger">' . '要求密码的长度为6～16个字符！' . "</div>";
            }
            else if (0 != strcmp($password_md5, $repeat_password_md5))
            {
                echo '<div id="alert" class="alert alert-danger">' . '两次输入密码不一致！' . "</div>";
            }
            else if (false == $this->validate('email', $email))
            {
                echo '<div id="alert" class="alert alert-danger">' . '请输入正确邮箱格式！' . "</div>";
            }
            else if (true == empty($_SESSION['captcha']) || 0 != strcasecmp($captcha, $_SESSION['captcha']))
            {
                echo '<div id="alert" class="alert alert-danger">' . '验证码错误！' . "</div>";
            }
            else
            {
                $checkusername = $database->select($user_tb, "*", ["username" => $username]);
                $checkemail = $database->select($user_tb, "*", ["email" => $email]);
                if (count($checkusername, 0))
                {
                    echo '<div id="alert" class="alert alert-danger">' . '用户名已存在！' . "</div>";
                }
                else if (count($checkemail, 0))
                {
                    echo '<div id="alert" class="alert alert-danger">' . '邮箱名已存在！' . "</div>";
                }
                else
                {
                    $last_user_id = $database->insert($user_tb, [
                        "username" => $username,
                        "password" => $password_md5,
                        "email" => $email,
                        "regist_date" => $current_date,
                    ]);
                    echo '<div class="alert alert-success">' . '恭喜您注册用户成功！' . '<a href="' . BASE_URL . '?c=user&m=login" class="alert-link">立即登录</a>' . "</div>";
                    $register_success = true;
                    //echo $last_user_id;
                }
            }
        }


        if (false == $register_success)
        {
//            require_once BASE_PATH.'/tool/create_captcha.php';
//            session_start(); 
//            echo '<img src="'.BASE_PATH.'/tool/create_captcha.php'.'"border=0 align=absbottom>';//生成图片 
//            echo $_SESSION["captcha"];//生成验证码值 

            $action = BASE_URL . '?c=user&m=register';
            include BASE_PATH . '/mvc/view/register_form.php';
        }
        include BASE_PATH . '/mvc/view/footer.php';
    }

    public function info()
    {
        $title = TITLE;
        $head1 = '用户资料';

        $css_file_array = array('/bootstrap/v3/css/bootstrap.css');

        include BASE_PATH . '/mvc/view/header.php';
        include BASE_PATH . '/mvc/view/footer.php';
    }

}
