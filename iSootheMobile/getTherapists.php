<?php
/**
 * Created by PhpStorm.
 * User: Costasv
 * Date: 3/1/15
 * Time: 12:41 AM
 */
error_reporting(E_ALL ^ E_NOTICE);
/*SELECT p.therapistId, p.patientLogin, p.patientPassword, p.patientLastName, p.patientEmail, t.therapistName
FROM patient p
inner join therapist t on p.therapistId = t.therapistId
where patientLogin = 'cvrahimis' and patientPassword = 'password' Limit 1;*/

if(isset($_POST['Username']) && isset($_POST['Password'])) {

    $db = new SQLite3('../DB/aCope.sqlite');
    $username = mysql_real_escape_string($_POST['Username']);
    $password = mysql_real_escape_string($_POST['Password']);
    $results = $db->query("SELECT p.therapistId, p.patientLogin, p.patientPassword, p.patientLastName, p.patientEmail, t.therapistName FROM patient p inner join therapist t on p.therapistId = t.therapistId where patientLogin = '".$username."' and patientPassword = '".$password."' Limit 1;");

    $str = $results['therapistId'].",".$results['patientLogin'].",".$results['patientPassword'].",".$results['patientLastName'].",".$results['patientEmail'].",".$results['therapistName'];
    echo $str;
}
?>