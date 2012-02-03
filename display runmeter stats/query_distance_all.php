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

// $dataArray=array();
 
//get data with db query
$sql="SELECT Activity, SUM(Distance) AS All_Miles FROM $databasetable WHERE Activity = 'run' ";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$distance = mysql_fetch_object($result);
// return RUN data
$distance_total_r = $distance -> All_Miles;
$distance_total_r = number_format($distance_total_r);

$sql="SELECT Activity, SUM(Distance) AS All_Miles FROM $databasetable WHERE Activity = 'walk' ";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$distance = mysql_fetch_object($result);
// return WALK data
$distance_total_w = $distance -> All_Miles;
$distance_total_w = number_format($distance_total_w);
@mysql_close($con);
?>