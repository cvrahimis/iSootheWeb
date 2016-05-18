<?php
/**
 * Created by PhpStorm.
 * User: Costasv
 * Date: 3/12/15
 * Time: 9:41 AM
 */
error_reporting(E_ALL ^ E_NOTICE);

//$db = new SQLite3('aCope.sqlite');
//if($db) {
    //if (isset($_POST['activity'])) {

        //$xml = $_POST['activity'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>
                <notes>
                <note>
                <to>Tove</to>
                <from>Jani</from>
                <heading>Reminder</heading>
                <body>Don't forget me this weekend!</body>
                </note>
                <note>
                <to>Costas</to>
                <from>Jani</from>
                <heading>Reminder</heading>
                <body>Don't forget me this weekend!</body>
                </note>
                </notes>";



        $notes=simplexml_load_string($xml) or die("Error: Cannot create object");
        print_r($notes);

        //echo count($notes);
        echo "</br>";
        //echo count($notes->note)
        $note = $notes->note;

        for($i = 0; $i < count($note); $i++)
        {
            echo $note[$i]->to;
            echo "</br>";
            echo $note[$i]->from;
            echo "</br>";
            echo $note[$i]->heading;
            echo "</br>";
            echo $note[$i]->body;
            echo "</br>";
            echo "</br>";
        }


        //array_push($stack, $activityData);




        /*for($i = 0; $i < count($stack); $i++)
        {
            $item = $stack[$i]->channel->item;
            for($j = 0; $j <= 10; $j++)
            {
                $link = $item[$j]->link;
                $title = $item[$j]->title;
            }
        }*/
        //if($db->query("INSERT INTO activities (therapistId, patientId, time, mood, urge, activity, duration) VALUES('".$activityData['therapistId']."')")){

        //}
    //}
//}


?>