<?php

class Tool {

    static function start_session($expire = 0) //单位秒
    {
        if($expire == 0)
        {
            $expire = ini_get('session.gc_maxlifetime');
            session_start();
        }
        else
        {
            ini_set('session.gc_maxlifetime', $expire);
            session_set_cookie_params($expire);
            session_start();
        }

        if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expire))
        {
            session_unset();
            session_destroy();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

}
?>

