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
$db = new SQLite3('../DB/aCope.sqlite');
if($db) {
    if (isset($_POST['Username']) && isset($_POST['Password'])) {

        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $results = $db->query("SELECT p.patientId, p.therapistId, p.patientLogin, p.patientPassword, p.patientFirstName, p.patientLastName, t.therapistFirstName, t.therapistLastName FROM patient p inner join therapist t on p.therapistId = t.therapistId where p.patientLogin = '" . $username . "' and p.patientPassword = '" . $password . "' Limit 1;");
        $row = $results->fetchArray();
        $str = $row['patientId'] . "," . $row['therapistId'] . "," . $row['patientLogin'] . "," . $row['patientPassword'] . "," . $row['patientFirstName'] . "," . $row['patientLastName'] . "," . $row['therapistFirstName'] . "," . $row['therapistLastName'];
        echo $str;
    } else {
        $results = $db->query("SELECT p.patientId, p.therapistId, p.patientLogin, p.patientPassword, p.patientFirstName, p.patientLastName, t.therapistFirstName, t.therapistLastName FROM patient p inner join therapist t on p.therapistId = t.therapistId where p.patientLogin = 'cvrahimis' and p.patientPassword = 'password' Limit 1;");
        $row = $results->fetchArray();
        $str = $row['patientId'] . "," . $row['therapistId'] . "," . $row['patientLogin'] . "," . $row['patientPassword'] . "," . $row['patientFirstName'] . "," . $row['patientLastName'] . "," . $row['therapistFirstName'] . "," . $row['therapistLastName'];
        echo $str;
    }
}
?>