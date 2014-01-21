<form name="login_form" method="post" action=<?php echo $action;?> onsubmit="return validate();">
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

