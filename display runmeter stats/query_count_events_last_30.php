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
 
//get data from database
$sql="SELECT COUNT(*) AS Last30Days FROM $databasetable WHERE Activity = 'run' AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= Start_Time";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$event_count=mysql_fetch_object($result);
$event_count=$event_count->Last30Days;

// days run will be $count_events_data from 30 == days off 
$days_off = 30 - $event_count;

@mysql_close($con);
?>