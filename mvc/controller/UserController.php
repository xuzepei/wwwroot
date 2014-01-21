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
        $css_file_array = array('/bootstrap/v3/css/bootstrap.css');
        $js_file_array = array('/js/login_validate.js');

        include BASE_PATH . '/mvc/view/header.php';


        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo(DB_NAME);

        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_tb = "user_tb";


        $current_date = date('Y-m-d H:i:s', time());

        if (!empty($username))
        {
            $sql = 'select * from ' . $user_tb . ' where username = "' . $username . '" && ' . 'password = "' . $password . '"';
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
                $sql = 'select * from ' . $user_tb . ' where email = "' . $username . '" && ' . 'password = "' . $password . '"';
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

    public function register()
    {
        $title = TITLE;
        $head1 = '用户注册';

        $css_file_array = array('/bootstrap/v3/css/bootstrap.css','/css/register_form.css');
        $js_file_array = array('/js/register_validate.js');

        include BASE_PATH . '/mvc/view/header.php';
        $register_success = false;

        require_once BASE_PATH . '/db/medoo.php';
        $database = new medoo(DB_NAME);

        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];
        $email = $_POST['email'];
        $user_tb = "user_tb";

        $current_date = date('Y-m-d H:i:s', time());
        
        if (!empty($email)&&!empty($username))
        {
            $checkusername = $database->select($user_tb, "*", ["username" => $username]);
            $checkemail = $database->select($user_tb, "*", ["email" => $email]);
            if (count($checkusername, 0))
            {
                echo '<div id="alert" class="alert alert-danger">'.'用户名已存在！'."</div>";
            }
            else if (count($checkemail, 0))
            {
                echo '<div id="alert" class="alert alert-danger">'.'邮箱名已存在！'."</div>";
            }
            else
            {
                $last_user_id = $database->insert($user_tb, [
                    "username" => $username,
                    "password" => $password,
                    "email" => $email,
                    "regist_date" => $current_date,
                ]);
                echo '<div class="alert alert-success">'.'恭喜您注册用户成功！'.'<a href="'.BASE_URL.'?c=user&m=login" class="alert-link">立即登录</a>'."</div>";
                $register_success = true;
                //echo $last_user_id;
            }
        }

        if(false == $register_success)
        {
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