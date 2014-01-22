/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* type: danger,warning,info,success*/
function showAlert(type,text)
{
    var alert = document.getElementById('alert');
    var form = document.getElementById('login_form');
    
    var html = '<div id="alert" class="alert alert-'+type+'">'+text+'</div>';

    if(alert)
        alert.parentNode.removeChild(alert);
    form.insertAdjacentHTML("beforeBegin",html);
}


function validate(){
  
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    
    if(0 == username.length)
    {
        showAlert("danger","请输入用户名！");
        return false;
    }
    
    if(0 == password.length)
    {
        showAlert("danger","请输入密码！");
        return false;
    }
    
    return true;
}
