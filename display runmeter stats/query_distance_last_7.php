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

$dataArray=array();
 
//get data with db query
$sql="SELECT Activity, SUM(Distance) AS Last7Days FROM $databasetable WHERE Activity = 'run' AND DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= Start_Time";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$distance_7 = mysql_fetch_object($result);
// return data
$distance_7 = $distance_7 -> Last7Days;
$distance_7 = number_format($distance_7);
$distance_per_day = $distance_7 / 7;
$distance_per_day = number_format($distance_per_day,1);
@mysql_close($con);
?>