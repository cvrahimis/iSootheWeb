<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>

<html>
    
    <head>
        
        <title>iSoothe </title>
        
        <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5;initial-scale=0.98;user-scalable=no;width=1024'>
            
            <link rel='stylesheet' type = 'text/css' href='CSS/menuStyles.css'>
                <style>  body {background-image: url("images/BKGD.jpg")}</style>

                </head>
    
    
    
    <body>
        <div id = "TitleBar">
            <span id="TitleBarSpan"><img src="images/iSoothe.png" style="width:90%;height=90%;" /></td></span>
        </div>
        <div border="2px" style="margin-top:100px;" align="center">
            
            <table>
                <tr>
                    <td id="NonAdminLogin" align="center">
                        <a href="Logins/therapistlogin.php">
                            <img src="images/therapistlogin.png" style="width:50%;height=50%;" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td id="NonAdminLogin" align="center">
                        <a href="Logins/dualLogin.php">
                            <img src="images/TherapistPatientLogin.png" style="width:75%;height=75%;" />
                        </a>
                    </td>
                </tr>
            </table>
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                                    
            <div id = "adminbutton" align="left">
                <a href="Logins/adminlogin.php">
                    <img src="images/admin.png" style="width:20%;height=20%;" />
                </a>
                <br /><br /><br />
            </div>
        </div>    
    </body>
    
    
</html>