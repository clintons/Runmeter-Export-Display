<?php
include ("../dbinfo.inc.php");
/********************************/
/* Code from http://strombotne.com/
/* The query in this file is for PHP5 only
/* If you use this code, find a flaw, enhance or otherwise improve it then please let me know
/* via comment or link.
/********************************/
$con = @mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
@mysql_select_db($databasename) or die('Could not connect: ' . mysql_error());
// echo "hello world";
 
// get data with db query
$sql="SELECT Activity, SEC_TO_TIME(AVG(TIME_TO_SEC(`Average_pace`))) AS Avg_Pace FROM $databasetable WHERE Activity = 'run' AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= Start_Time";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$Pace = mysql_fetch_object($result);
// return data
$Pace1 = $Pace -> Avg_Pace;

// get data with db query
$sql="SELECT Activity, AVG(Average_pace_seconds) AS Avg_Pace_sec FROM $databasetable WHERE Activity = 'run' AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= Start_Time";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$Pace = mysql_fetch_object($result);
// return data
$Pace2 = $Pace -> Avg_Pace_sec;

// $Pace2=  number_format($Pace2);
// echo $Pace1;

$Pace2 = number_format($Pace2);
// echo $Pace2;
@mysql_close($con);
?>
 