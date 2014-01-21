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

/* type: danger,warning,info,success*/
function showAlert(type,text)
{
    var alert = document.getElementById('alert');
    var form = document.getElementById('register_form');
    
    var html = '<div id="alert" class="alert alert-'+type+'">'+text+'</div>';

    if(alert)
        alert.parentNode.removeChild(alert);
    form.insertAdjacentHTML("beforeBegin",html);
}

function validate(){

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var repeat_password = document.getElementById('repeat_password').value;
    var email = document.getElementById('email').value;
     
    if(0 == username.length)
    {
        showAlert("danger","请填写用户名！");
        
        return false;
    }
    
    if(username.length <2 || username.length >16)
    {
        showAlert("danger","要求用户名的长度为2～16个字符！");
        return false;
    }
    
    if(0 == password.length)
    {
        showAlert("danger","请填写密码！");
        return false;
    }
    
    if(password.length <6 || password.length >16)
    {
        showAlert("danger","要求密码的长度为6～16个字符！");
        return false;
    }
    
    if(password != repeat_password)
    {
        showAlert("danger","两次输入密码不一致！");
        return false;
    }
    
    if(0 == email.length)
    {
        showAlert("danger","请输入邮箱！");
        return false;
    }
    
    if(!isEmail(email))
    {
        showAlert("danger","请输入正确邮箱格式！");
        return false;
    }
    
    return true;
}
