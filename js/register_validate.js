/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function isEmail(email){ 
    var regexp = /^[\w-]+(\.[\w]+)*@([\w-]+\.)+[a-zA-z]{2,7}$/;
    if(email.match(regexp)) 
        return true; 

    return false; 
} 

function validate(){
  
    var username = document.register_form.username.value;
    var password = document.register_form.password.value;
    var repeat_password = document.register_form.repeat_password.value;
    var email = document.register_form.email.value;
    
    if(0 == username.length)
    {
        alert("请填写用户名！");
        return false;
    }
    
    if(username.length <2 || username.length >16)
    {
        alert("要求用户名的长度为2～16个字符！");
        return false;
    }
    
    if(0 == password.length)
    {
        alert("请填写密码！");
        return false;
    }
    
    if(password.length <6 || password.length >16)
    {
        alert("要求密码的长度为6～16个字符！");
        return false;
    }
    
    if(password != repeat_password)
    {
        alert("两次输入密码不一致！");
        return false;
    }
    
    if(0 == email.length)
    {
        alert("请输入邮箱！");
        return false;
    }
    
    if(!isEmail(email))
    {
        alert("请输入正确邮箱格式！");
        return false;
    }
    
    return true;
}
