
<form class="form-horizontal" role="form" name="register_form" id="register_form" method="post" action=<?php echo $action; ?> onsubmit="return validate();">
      <div class="form-group">
        <label class="col-sm-2 control-label">用户名:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-register" name="username" id="username" placeholder="" value=<?php echo '"' . $username . '"' ?>>
            <p class="help-block">要求用户名的长度为2～16个字符!</p>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">密码:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control form-control-register" name="password" id="password" placeholder="" value=<?php echo '"' . $password . '"' ?>>
        </div>
    </div>
    <div class="form-group form-group-register">
        <label for="repeat_password" class="col-sm-2 control-label">重复密码:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control form-control-register" name="repeat_password" id="repeat_password" placeholder="" value=<?php echo '"' . $repeat_password . '"' ?>>
        </div>
    </div>
    <div class="form-group form-group-register">
        <label for="email" class="col-sm-2 control-label">邮箱:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-register" name="email" id="email" placeholder="" value=<?php echo '"' . $email . '"' ?>>
        </div>
    </div>
    <div class="form-group form-group-register">
        <label for="captcha" class="col-sm-2 control-label">验证码:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-captcha" name="captcha" id="captcha" placeholder=""><?php echo '<img id="captcha_img" src="' . BASE_URL . '/tool/create_captcha.php' . '" onclick="reload_captcha();" border=0 align=absbottom/>'.'<a id="reload_captcha_request" href="#" onclick="reload_captcha();return false;">换一个</a>';?>
        </div>
    </div>

    <div class="form-group form-group-register">
        <label for="submit" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </div>
</form>