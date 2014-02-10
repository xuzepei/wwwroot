<form class="form-horizontal" role="form" name="login_form" id="login_form" method="post" action=<?php echo $action; ?> onsubmit="return validate();">
      <div class="form-group">
        <label class="col-sm-2 control-label">用户名/邮箱:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-login" name="username" id="username" placeholder="" value=<?php echo '"' . $username . '"' ?>>
        </div>
    </div>
    <div class="form-group form-group-login">
        <label for="password" class="col-sm-2 control-label">密码:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control form-control-login" name="password" id="password" placeholder="">
        </div>
    </div>
    <div class="form-group form-group-login">
        <label for="captcha" class="col-sm-2 control-label">验证码:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-captcha" name="captcha" id="captcha" placeholder=""><?php echo '<img id="captcha_img" src="' . BASE_URL . '/tool/create_captcha.php?t='.time().'" onclick="reload_captcha();" border=0 align=absbottom/>'.'<a id="reload_captcha_request" href="#" onclick="reload_captcha();return false;">换一个</a>';?>
        </div>
    </div>
    <div class="form-group form-group-login">
        <label for="submit" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">登录</button>
        </div>
    </div>
</form>

