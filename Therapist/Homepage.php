<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

?>

<!DOCTYPE html>

<html>

<head>

<title>iSoothe Home</title>

<meta name="viewport" content="minimum-scale=0.98; maximum-scale=5;initial-scale=0.98;user-scalable=no;width=1024">

<link rel="stylesheet" type = "text/css" href="../CSS/menuStyles.css">
<style>body{background-image: url("../images/BKGD.jpg");}</style>
</head>



<body>
    <div align="center">
    	<div id = "TitleBar">
            <span id = "TitleBarSpan1"><nobr><img src="../images/iSoothe.png" style="width:50%;height=50%;" /></nobr></span>
    	</div>
        <a href="../logout.php"><button id="LogOutbutton" type="button"><i><b>Log Out<b></i></button></a>

        <br><br>
        
    	<div id="Main">
            <div class = "Patient">

                <table width="1000px" height= "80px">
                    <tr>
                        <th><h2>Welcome!<h2></th>
                    </tr>
                </table>
            </div>
    		  <br><br>
            <div class = "Data">
                <table bgcolor="white" width="1000px" height= "350px" border="1px">
                    <tr>
                        <th><Center><h3>Activity</h3></center<</th>
                        <th><Center><h3>Time</h3></Center></th>
                        <th><Center><h3>Mood</h3></Center></th>
                        <th><Center><h3>Urge</h3></Center></th>
                        <th><Center><h3>Duration</h3></Center></th>
                        <th><Center><h3>Button Press</h3></th>
                    </tr>
                    <?php
                    $db = new SQLite3("../DB/aCope.sqlite"); //connect to the sqlite DB
                    //print_r($db);
                    if($db) // check if the connection was made
                    {   //SELECT * FROM activities where therapistId=1 and patientId=1 order by activityId desc limit 10;
                        //INSERT INTO activities (therapistId, patientId, time, mood, urge, activity, duration) VALUES(1,1, '4pm', 'pissed', 4, 'journal', '5 hours')
                        //echo "SELECT * FROM activities where therapistId=".$_SESSION['tID']." and patientId=".$_SESSION['pID'].";";
                        $result = $db->query("SELECT * FROM activities where therapistId=".$_SESSION['tID']." and patientId=".$_SESSION['pID']." order by activityId desc limit 10;");
                        if($result)
                        {
                            while ($row = $result->fetchArray()) 
                            {
                                echo "<tr>";
                                echo "<td><Center>".$row['activity']."</Center></td>";
                                echo "<td><Center>".$row['time']."</Center></td>";
                                echo "<td><Center>".$row['mood']."</Center></td>";
                                echo "<td><Center>".$row['urge']."</Center></td>";
                                echo "<td><Center>".$row['duration']."</Center></td>";
                                echo "<td><Center>NO</Center></td>";
                                echo "</tr>";
                            }
                        }
                    }   
                    
                    
                        
                    
                    ?>
             
                </table>
    		</div>
    	
        </div>

    </div>
</body>

</html>