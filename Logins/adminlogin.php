<?php
error_reporting(E_ALL ^ E_NOTICE);
//session start
session_start();

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $loinFailed = false;
    //print_r($_POST);

    //buttons
    $signin = $_POST['login'];
    $cancel = $_POST['cancel'];

    //form data, strip tags of any html
    $username = $_POST['uname'];
    $password = $_POST['password'];

    if($signin)
    {
        if($username && $password)
        {    
            //make database object
            $db = new SQLite3("../DB/aCope.sqlite");
            if($db)
            {
                //select admin by username
                $result = $db->query("SELECT * FROM administrator WHERE adminLogin='$username'");
                //print_r($result); ===== Debug
                $row = $result->fetchArray();
                if($row['adminLogin'] == $username && $row['adminPassword'] == $password)  //we will need to do some encryption on passwords in production
                {
                    $_SESSION['aUsername'] = $username;
                    $_SESSION['aID'] = $row['adminID'];

                    header("Location: ../Admin/AdminSettings.php");
                }
                else
                {
                    $loginFailed = true;
                }
                //print_r($row); //===== Debug
            }
        }
        else
        {
            $loginFailed = true;
        }

    }
    else
    {
        $loginFailed = true;
    }
    if($cancel == "Cancel")
    {
        header("Location: ../Entry.php");
    }    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>iSoothe</title>
        
        <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5;initial-scale=0.98;user-scalable=no;width=1024'>
            
            <link rel="stylesheet" type = "text/css" href="../CSS/menuStyles.css">
                <style>body{background-image: url("../images/BKGD.jpg");}</style>
                   </head>
    <body>
        
        <div id = "TitleBar">
            <span id = "TitleBarSpan">
            	<img src="../images/admin.png" style="width:120%;height=120%;" />
            </span>
        </div>

        <div border="2px" style="margin-top:100px" align="center">
            <?php
                if($loginFailed)
                {
                    echo "<center>";
                    echo '<div id="invalidLogin">';
                    echo "Invalid Login";
                    echo "</div>";
                    echo "</center>";
                    echo "<br />";
                }
            ?>
            <form method="POST" action="adminlogin.php">
                <table>
                    <tr>
                        <td style="color: black;">Admin Login:</td>
                        <td>
                        	<input type="text" name="uname">
                        </td>
                    </tr>
                    <tr>
                        <td style="color:black;"> Password:</td>
                        <td><input type="password" name="password"></td>
                    </tr>    
                    <tr>
                        <td colspan="2">
                        	<center>
                        		<input type="submit" name="login" value="Log In">
                                <input type="submit" name="cancel" value="Cancel">
                        	</center>
                        </td>
                    </tr>                                               
                </table>
            </form>
        </div>
    </body>
</html>
