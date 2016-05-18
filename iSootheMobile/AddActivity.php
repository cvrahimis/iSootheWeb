<?php
/**
 * Created by PhpStorm.
 * User: Costasv
 * Date: 3/21/15
 * Time: 6:33 PM
 */
error_reporting(E_ALL ^ E_NOTICE);

$db = new SQLite3('../DB/aCope.sqlite');
if($db)
{
    if (isset($_POST['activityXML'])) {
        $xml = $_POST['activityXML'];
        $didInsert = true;
        $activities = simplexml_load_string($xml) or die("Error: Cannot create object");

        $activity = $activities->activity;

        for($i = 0; $i < count($activity); $i++)
        {
            $therapistID = $activity[$i]->therapistId;
            $patientID = $activity[$i]->patientId;
            $time = $activity[$i]->time;
            $mood = $activity[$i]->mood;
            $urge = $activity[$i]->urge;
            $act = $activity[$i]->act;
            $duration = $activity[$i]->duration;
            if(!$db->query("INSERT INTO activities (therapistId, patientId, time, mood, urge, activity, duration) VALUES($therapistID , $patientID, '$time', '$mood', $urge, '$act', '$duration' );"))
                $didInsert = false;
        }
    }
$db->close();

    if($didInsert)
        echo "yes";
    else
        echo "no";
}

?>