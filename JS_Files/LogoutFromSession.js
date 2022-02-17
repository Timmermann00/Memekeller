function Logout()
{
    var logoutreq = new XMLHttpRequest();
    
    logoutreq.onreadystatechange=function()
    {
        if(logoutreq.readyState===4 && logoutreq.status===200)
            {
               window.location.href="../FrontEndHtmlPhp/StartPage.php";
            }
            else if(logoutreq.status===404)
            {
                alert("No server response");
            }
    };
     logoutreq.open("POST","../Ajax-phpScript/SessionLogout.php",true);
     logoutreq.send();
}



