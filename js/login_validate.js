/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function validate(){
  
    var username = document.login_form.username.value;
    var password = document.login_form.password.value;
    
    if(0 == username.length)
    {
        alert("请输入用户名！");
        return false;
    }
    
    if(0 == password.length)
    {
        alert("请输入密码！");
        return false;
    }
    
    return true;
}
