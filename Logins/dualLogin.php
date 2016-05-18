<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
    
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $loinFailed = false;
    //print_r($_POST);
        
    //buttons
    $signin = $_POST['login'];
    $cancel = $_POST['cancel'];
    
    //form data, strip tags of any html
    $tUsername = $_POST['uname2'];
    $tPassword = $_POST['password2'];
    $pUsername = $_POST['uname'];
    $pPassword = $_POST['password'];
    
    if($signin)
    {
        if($tUsername && $tPassword && $pUsername && $pPassword)
        { //make database object
            $db = new SQLite3("../DB/aCope.sqlite");
            if($db)
            {
                //echo "SELECT p.patientId, p.patientLogin, p.patientPassword, p.patientFirstName, p.patientLastName, t.therapistId, t.therapistLogin, t.therapistPassword, t.therapistFirstName, t.therapistLastName FROM therapist t inner join patient p on t.therapistId=p.therapistId where t.therapistLogin='$tUsername' and t.therapistPassword='$tPassword' and p.patientLogin='$pUsername' and p.patientPassword='$pPassword'";
                //select therapist by username
                $result = $db->query("SELECT p.patientId, p.patientLogin, p.patientPassword, p.patientFirstName, p.patientLastName, t.therapistId, t.therapistLogin, t.therapistPassword, t.therapistFirstName, t.therapistLastName FROM therapist t inner join patient p on t.therapistId=p.therapistId where t.therapistLogin='$tUsername' and t.therapistPassword='$tPassword' and p.patientLogin='$pUsername' and p.patientPassword='$pPassword';");
               
                //print_r($result);// ===== Debug
                
                $row = $result->fetchArray();
                //print_r($row);

                //echo $row['therapistLogin'] == $tUsername && $row['therapistPassword'] == $tPassword && $row['patientLogin'] == $pUsername && $row['patientPassword'] == $pPassword;
                
                if($row['therapistLogin'] == $tUsername && $row['therapistPassword'] == $tPassword && $row['patientLogin'] == $pUsername && $row['patientPassword'] == $pPassword) //we will need to do some encryption on passwords in production
                {
                    $_SESSION['tUsername'] = $tUsername;
                    $_SESSION['tID'] = $row['therapistId'];
                    $_SESSION['pUsername'] = $pUsername;
                    $_SESSION['pID'] = $row['patientId'];

                    header("Location: ../Therapist/Homepage.php");
                }
                else
                {
                    $loginFailed = true;
                }
                //print_r($row);// ===== Debug
                
                
            }
        }
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
    <title>iSoothe Dual Login </title>
    
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5;initial-scale=0.98;user-scalable=no;width=1024'>
        
        <link rel='stylesheet' type = 'text/css' href='../CSS/menuStyles.css'>
            <style>body{background-image: url("../images/BKGD.jpg");}</style>

    
    </head>
    
    
    <body>
        <div id="TitleBar">
            <span id="TitleBarSpan2">
                <img src="../images/TherapistPatientLogin.png" style="width:100%;height=100%;" />
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
     		<form method="POST" action="dualLogin.php">
    			<table>
                    <tr>
                        <td style="color: black;">
                            Patient Username:
                        </td>
                        <td>
                            <input type="text" name="uname">
                        </td>
                    </tr>
                    <tr>
                        <td style="color:black;">
                            Patient Password:
                        </td>
                        <td>
                            <input type="password" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td style="color: black;">
                            Therapist Username:
                        </td>
                        <td>
                            <input type="text" name="uname2">
                        </td>
                    </tr>
                    <tr>
                        <td style="color:black;">
                            Therapist Password:
                        </td>
                        <td>
                            <input type="password" name="password2">
                        </td>
                    </tr>
    				<tr>
    					<td colspan='2'>
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