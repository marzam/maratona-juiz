function forgot_password(){
    document.getElementById("id_login").action = 'forgot.php';
    document.getElementById('id_login').submit();
}
//------------------------------------------------------------------
function delete_cookie(cookie_name){
    var cookie_date = new Date ( );  // current date & time
    cookie_date.setTime (cookie_date.getTime() - 1);
    document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function logout(){
  delete_cookie('login-team');
   window.open("login.php", "_self");
}

//------------------------------------------------------------------