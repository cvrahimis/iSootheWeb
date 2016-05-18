<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
//check if the page was called by the POST action
if($_SERVER['REQUEST_METHOD']=='POST')
{
    //print_r($_POST); //==== Debug


    $submittedForm = $_POST['submittedForm'];//Post varriable that holds which form did the submitt/post action
    $message = ""; //make a string varriable that will pop up messages to the user
    $db = new SQLite3("../DB/aCope.sqlite"); //connect to the sqlite DB
    if($db) // check if the connection was made
    {
        if($submittedForm == "newTherapist") //check if it was the new therapist form
        {
            $firstName = $_POST['fName']; //vars to hold form input
            $lastName = $_POST['lName'];
            $username = $_POST['uname'];
            $password = $_POST['password'];
            $confirmPass = $_POST['password2'];
            $email = $_POST['email'];
            //echo "SELECT * FROM therapist WHERE therapistLogin = '$username'"; //======Debug
            $result = $db->query("SELECT * FROM therapist WHERE therapistLogin='$username'"); //query therapist table to see if username already exists
            //print_r($result); //=====Debug
            $row = $result->fetchArray(); // fetch the results
            //print_r($row); //=====Debug
            //echo count($row); //=====Debug
            if(count($row) > 1) //if the user does not exist the count of $row is 1 idk why but if a therapist exists with the username it will be > 1
            {
                $message = "Therapist already exists"; //set $message
            }
            if($password != $confirmPass) //check if passwords do not match
            {
                $message = "Passwords do no match"; //set $message
            }
            if($message == "") //if nothing was wrong from before insert the therapist
            {
                if($db->query("INSERT INTO Therapist (therapistLogin, therapistPassword, therapistFirstName, therapistLastName, therapistEmail) VALUES ('$username', '$password', '$firstName', '$lastName', '$email');"))
                {
                    $message = "Successfully added therapist";
                }
            }
        }
    }
    if($submittedForm == "deleteTherapist") //check if it was the delete therapist form
    {
        //print_r($_POST);
        $username = $_POST['uname'];
        $newTherapistUname = $_POST['NewTUname'];
        
        $resultNewTherapist = $db->query("SELECT count(*) as count FROM therapist t WHERE t.therapistLogin='$newTherapistUname';");
        $row = $resultNewTherapist->fetchArray();
        $numNewTherapistRows = $row['count'];

        $resultOldTherapist = $db->query("SELECT count(*) as count FROM therapist t WHERE t.therapistLogin='$username';");
        $row = $resultOldTherapist->fetchArray();
        $numOldTherapistRows = $row['count'];

        if($numNewTherapistRows > 0 && $numOldTherapistRows > 0)    
        {    
            $resultNewTherapist = $db->query("SELECT * FROM therapist t WHERE t.therapistLogin='$newTherapistUname';");
            $rowNewTherapist = $resultNewTherapist->fetchArray();
            $resultOldTherapist = $db->query("SELECT * FROM therapist t WHERE t.therapistLogin='$username';");
            $rowOldTherapist = $resultOldTherapist->fetchArray();
            //echo "UPDATE patient SET therapistID = ".$rowNewTherapist['therapistId']." WHERE therapistID=".$rowOldTherapist['therapistId'].";";
            $result = $db->query("UPDATE patient SET therapistId = ".$rowNewTherapist['therapistId']." WHERE therapistId=".$rowOldTherapist['therapistId'].";");
            if($db->changes() > 0)
                $message = "Successfully deleted therapist";
            else
                $message = "Could not delete therapist, could not transfer patients to a different therapist.";
            
        }
    }
    if($submittedForm == "changeTherapistPW") //check if it was the change password from
    {
        $username = $_POST['uname'];
        $password = $_POST['pw'];
        $confirmPass = $_POST['pw2'];
        if($db->query("UPDATE therapist SET therapistPassword = '$password' WHERE therapistLogin='$username';"))
            $message = "Successfully changed therapist password";
        else
            $message = "Could not change therapistPassword";
    }
}



?>

<html>
    <head>
        <title>iSoothe Administrative Interface</TITLE>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <meta name="viewport" content="minimum-scale=0.98; maximum-scale=5;  initial-scale=0.98; user-scalable=no; width=640">
                <link rel="stylesheet" type="text/css" href="../CSS/adminStyles.css">
                    <script language="Javascript" type="text/javascript" src="../JavaScript/AdminMethods.js"></script>
    </head>
    <style>body{background-image: url("../images/BKGD.jpg")}</style>
    <div align="center">
        <div id = "TitleBar">
            <span id="TitleBarSpan"><nobr><img src="../images/AdminInterface.png" style="width:60%;height=60%;" /></nobr></span>
            <a href="../logout.php"><button id="LogOutbutton" type="button"><i><b>Log Out<b></i></button></a>
        </div>
        
        <div id="ActionSelectors">
            <table border="0" cellspacing="0">
                <tr>
                    <td height="25px"></td>
                </tr>
                <tr>
                    <td id="AdminBtn0" class="option" onmouseover="MenuItem_OnMouseOver(0);" onmouseout="MenuItem_OnMouseOut(0);" onclick="toggleAddTherapistInterface();">
                        <div class="optionContents">
                        	<center>New Therapist</center>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td height="25px"></td>
                </tr>
                <tr>
                	<td height="25px">
                	</td>
                </tr>
                <tr>
                    <td id="AdminBtn1" class="option" onmouseover="MenuItem_OnMouseOver(1);" onmouseout="MenuItem_OnMouseOut(1);" onclick="toggleDeleteTherapistInterface();">
                        <div class="optionContents">
                        	<center>Delete Therapist</center>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td height="25px"></td>
                </tr>
                <tr>
                	<td height="25px"></td>
                </tr>
                <tr>
                    <td id="AdminBtn2" class="option" onmouseover="MenuItem_OnMouseOver(2);" onmouseout="MenuItem_OnMouseOut(2);" onclick="toggleChangePWInterface();">
                        <div class="optionContents">
                        	<center>Change Therapist Password</center>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td height="25px"></td>
                </tr>    
            </table>
        </div>
        
        <div id="newTherapistDiv" style="visibility:hidden; position: absolute; margin-top: -210px; margin-left: 810px;">
            <form id="newTherapist">
                <table>
                    <tr>
                        <td colspan="2"><center>New Therapist</center></td>
                    </tr>
                    <tr>
                        <td >Enter First Name:</td>
                        <td><input id="ADDFirstName" type="text" name="fName" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td >Enter Last Name:</td>
                        <td><input id="ADDLastName" type="text" name="lName" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td >Enter Username:</td>
                        <td><input id="ADDUserName" type="text" name="uname" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter Password:</td>
                        <td><input id="ADDPassword" type="password" name="password" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input id="ADDPassword2" type="password" name="password2" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter Email:</td>
                        <td><input id="ADDEmail" type="text" name="email" onKeyup="didFillAllNewTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td><input id="newTherapistBtn" type="button" name="createTherapist" value="Create" onclick="newTherapist('newTherapist');" disabled></td>
                        <td><input type="button" name="cancel" value="Cancel" onclick="toggleAddTherapistInterface();"></td>
                    </tr>
                </table>
            </form>
        </div>
        
        
        <div id="deleteTherapistDiv" style="visibility:hidden; position: absolute; margin-top: -140px; margin-left: 160px;">
            <form id="deleteTherapist">
                <table>
                    <tr>
                        <td colspan="2"><center>Delete Therapist</center></td>
                    </tr>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input id="DELUserName" type="text" name="uname" onKeyup="didFillAllDeleteTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter New Therapist Username:</td>
                        <td><input id="NewTherapistID" type="text" name="NewTUname" onKeyup="didFillAllDeleteTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td><input id="deleteTherapistBtn" type="button" name="deleteTherapist" value="Delete" onclick="deleteTheTherapist('deleteTherapist');" disabled></td>
                        <td><input type="button" name="cancel" value="Cancel" onclick="toggleDeleteTherapistInterface();"></td>
                    </tr>
                </table>
            </form>
        </div>
        
        <div id="changeTherapistPWDiv" style="visibility:hidden; position: absolute; margin-top: -140px; margin-left: 810px">
            <form id="changeTherapistPW">
                <table>
                    <tr>
                        <td colspan="2"><center>Change Therapist Password</center></td>
                    </tr>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input id="PasswordChangeUserName" type="text" name="uname" onKeyup="didFillAllChangePWTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter Password:</td>
                        <td><input id="NewPW" type="password" name="pw" onKeyup="didFillAllChangePWTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input id="NewPWConfirm" type="password" name="pw2" onKeyup="didFillAllChangePWTherapistInputs()"></td>
                    </tr>
                    <tr>
                        <td><input id="changeTherapistPWBtn" type="button" name="changeTherapistPW" value="Change" onclick="changePW('changeTherapistPW');" disabled></td>
                        <td><input type="button" name="cancel" value="Cancel" onclick="toggleChangePWInterface();"></td>
                    </tr>
                </table>
            </form>
        </div>
    
        </body>
</html>

<?php
    if($message != "")
    {
        echo '<script language="javascript">';
        echo 'alert("'.$message.'")';
        echo '</script>';
    }
?>
