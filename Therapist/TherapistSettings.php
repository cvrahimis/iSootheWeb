<?php
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    //print_r($_SESSION);
    //echo $_SERVER['REQUEST_METHOD'];
    //check if the page was called by the POST action
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
      //  print_r($_POST); //==== Debug
        
        
        $submittedForm = $_POST['submittedForm'];//Post varriable that holds which form did the submitt/post action
        $message = ""; //make a string varriable that will pop up messages to the user
        $db = new SQLite3("../DB/aCope.sqlite"); //connect to the sqlite DB
        if($db) // check if the connection was made
        {
            //echo $submittedForm;
            if($submittedForm == "newPatient") //check if it was the new patient form
            {
                $firstName = $_POST['fName']; //vars to hold form input
                $lastName = $_POST['lName'];
                $username = $_POST['uname'];
                $password = $_POST['password'];
                $confirmPass = $_POST['password2'];
                $email = $_POST['email'];
                //echo "SELECT * FROM patient WHERE patientLogin = '$username'"; //======Debug
                $result = $db->query("SELECT * FROM patient WHERE patientLogin='$username'"); //query patient table to see if username already exists
                //print_r($result); //=====Debug
                $row = $result->fetchArray(); // fetch the results
                print_r($row); //=====Debug
                //echo count($row); //=====Debug
                if(count($row) > 1) //if the user does not exist the count of $row is 1 idk why but if a patient exists with the username it will be > 1
                {
                    $message = "Patient already exists"; //set $message
                }
                if($password != $confirmPass) //check if passwords do not match
                {
                    $message = "Passwords do no match"; //set $message
                }
                if($message == "") //if nothing was wrong from before insert the patient
                {
                    //echo "INSERT INTO Patient (therapistId, patientLogin, patientPassword, patientFirstName, patientLastName, patientEmail) VALUES (".$_SESSION['tID'].",'$username', '$password', '$firstName', '$lastName', '$email');";
                    if($db->query("INSERT INTO Patient (therapistId, patientLogin, patientPassword, patientFirstName, patientLastName, patientEmail) VALUES (".$_SESSION['tID'].",'$username', '$password', '$firstName', '$lastName', '$email');")){
                        $message = "Successfully added patient.";
                    }
                }
            }
            if($submittedForm == "deletePatient") //check if it was the delete patient form
            {
                $username = $_POST['uname'];
                if($db->query("DELETE FROM patient WHERE patient Login='$username';"))
                    $message = "Successfully deleted patient";
                else
                    $message = "Could not delete patient";
            }
            if($submittedForm == "changePatientPW") //check if it was the change password from
            {
                $username = $_POST['uname'];
                $OldPW = $_POST['OPW'];
                $password = $_POST['pw'];
                $confirmPass = $_POST['pw2'];
                if($db->query("SELECT patientPassword, patientLogin FROM patient WHERE patientLogin='$username' && patientPassword='$OldPW';"))
                    echo "UPDATE patient SET patientPassword = '$password' WHERE patientLogin='$username';";
                    if($db->query("UPDATE patient SET patientPassword = '$password' WHERE patientLogin='$username';"))
                    $message = "Successfully changed patient password";
                else
                    $message = "Could not change patient Password";
            }
        }
    }
    
    
    ?>

<html>
    <head>
        <title>iSoothe Therapist Interface</TITLE>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <meta name="viewport" content="minimum-scale=0.98; maximum-scale=5;  initial-scale=0.98; user-scalable=no; width=640">
                <link rel="stylesheet" type="text/css" href="../CSS/therapistStyles.css">
                    <script language=Javascript type="text/javascript" src="../JavaScript/TherapistMethods.js"></script>
                    </head>
    <style>body{background-image: url("../images/BKGD.jpg")}</style>
    <div align="center">
        <div id = "TitleBar">
            <span id = "TitleBarSpan"><nobr><img src="../images/TherapistInterface.png" style="width:60%;height=60%;" /></nobr></span>
            <a href= "../logout.php"><button id="LogOutbutton" type="button"><i><b>Log Out<b></i></button></a>
        </div>
        
        <div id="ActionSelectors">
            <table border="0" cellspacing="0">
                
                <tr>
                    <td height="25px"></td>
                </tr>
                <tr>
                    <td id="TBtn0" class="option"
                        onmouseover="MenuItem_OnMouseOver(0);"
                        onmouseout="MenuItem_OnMouseOut(0);"
                        onclick="toggleAddPatientInterface();">
                        <div class="optionContents">
                                <center>New Patient</center>
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
                    <td id="TBtn1" class="option"
                        onmouseover="MenuItem_OnMouseOver(1);"
                        onmouseout="MenuItem_OnMouseOut(1);"
                        onclick="toggleDeletePatientInterface();">
                        <div class="optionContents">
                            <center>Delete Patient</center>
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
                    <td id="TBtn3" class="option"
                        onmouseover="MenuItem_OnMouseOver(3);"
                        onmouseout="MenuItem_OnMouseOut(3);"
                        onclick="toggleChangePWInterface();">
                        <div class="optionContents">
                                <center>Change Patient Password</center>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="25px"></td>
                </tr>

            </table>
        </div>
        
        <div id="NewPatientDiv"  style="visibility:hidden; position: absolute; margin-top: -210px; margin-left: 810px;">
            <form id="newPatient">
                <table>
                    <tr>
                        <td >Enter First Name:</td>
                        <td><input id="ADDFirstName" type="text" name="fName" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td >Enter Last Name:</td>
                        <td><input id="ADDLastName" type="text" name="lName" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td >Enter Username:</td>
                        <td><input id="ADDUserName" type="text" name="uname" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter  NewPassword:</td>
                        <td><input id="ADDPassword" type="password" name="password" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td >Confirm Password:</td>
                        <td><input id="ADDPassword2" type="password" name="password2" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        
                        <td >Enter Email:</td>
                        <td><input id="ADDEmail" type="text" name="email" onKeyup="didFillAllNewPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td><input id="newPatientBtn" type="button" name="createPatient" value="Create" onclick="newPatient('newPatient');" disabled></td>
                        <td><input type="button" value="Cancel" onclick="toggleAddPatientInterface();"></td>
                    </tr>
                </table>
            </form>
        </div>
        
        
        
        
        <div id="DeleteDiv" style="visibility:hidden; position: absolute; margin-top: -140px; margin-left:  160px;">
            <form id="deletePatient">
                <table>
                    <tr>
                        <td colspan="2"><center>Delete Patient</center></td>
                    </tr>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input id="DELUserName" type="text" name="uname" onKeyup="didFillAllDeletePatientInputs()"></td>
                    </tr>
                    <tr>
                        <td><input id="deletePatientBtn" type="button" name="deletePatient" value="Delete" onclick="deleteThePatient('deletePatient');" disabled></td>
                        <td><input type="button" value="Cancel" onclick="toggleDeletePatientInterface();"></td>
                    </tr>
                </table>
            </form>
        </div>
        
        <div id="PatientPasswordDiv" style="visibility:hidden; position: absolute; margin-top: -220px; margin-left: 810px">
            <form id="changePatientPW">
                <table>
                    <tr>
                        <td colspan="2"><center>Change Patient Password</center></td>
                    </tr>
                    <tr><font color=Red><h3>PLEASE NOTE: PATIENT MUST BE PRESENT TO CHANGE PATIENT PASSWORD OR THERAPIST WILL BE LIABILE!</h2></font color=red>
                    <tr>
                    <tr>
                        <td>Enter Username:</td>
                        <td><input id="PasswordChangeUserName" type="text" name="uname" onKeyup="didFillAllChangePWPatientInputs()"></td>
                    </tr>
                      <tr>
                        <td>Enter  Old Password:</td>
                        <td><input id="OLDPW" type="password" name="OPW" onKeyup="didFillAllChangePWPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td>Enter  New Password:</td>
                        <td><input id="NEWPW" type="password" name="pw" onKeyup="didFillAllChangePWPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td >Confirm Password:</td>
                        <td><input id="NewPWConfirm" type="password" name="pw2" onKeyup="didFillAllChangePWPatientInputs()"></td>
                    </tr>
                    <tr>
                        <td><input  id="changePatientPWBtn" type="button" name="changePatientPW" value="Change" onclick="changePW('changePatientPW');" disabled></td>

                        <td><input type="button" value="Cancel" onclick="toggleChangePWInterface();"></td>
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

