<?php
include 'dbinfo.inc.php'; //   your variable constants for database access
/**********************************/
/* Code from http://strombotne.com/
/* As the file name implies, this code will import your data from Runmeter.  You may run this file manually or better still, by setting up a cron job. 
/* Edit the entry below to reflect the appropriate value i.e. your unique Runmeter export URL which should look something like this: "http://share.abvio.com/438h2 53u978cd/Runmeter-Route-All.csv"
/*********************************/
$inp = file('http://share.abvio.com/***********/Runmeter-Route-All.csv');
/*********************************/
/* If you use this code, find a flaw, enhance or otherwise improve it then please let me know
/* via comment or link.  clintons@yahoo.com
/* End Edit (nothing to do below this line)
/*********************************/

if (!$inp) {
    echo "<p>Unable to open remote file.\n";
    exit;
}
$out = fopen('runmeter_clean.csv','w');   //  a flat file which will temporaily hold your imported data
for ($i=1;$i<count($inp)-1;$i++)  // step through the cvs file to leave out the first line ($i=1) and the last line of the file (count($inp)-1) because the first line is a header row and the last line has extraneous data
{
 fwrite($out,$inp[$i]);
}
fclose($out);

echo "<font color=red>{$i} Runmeter events</font><br>"; 

$file_handle = fopen('runmeter_clean.csv',"r");

$con = @mysql_connect($databasehost,$databaseusername,$databasepassword) or die(mysql_error());
@mysql_select_db($databasename) or die(mysql_error());

// first task: let's empty the mysql table (remove all existing recors)
mysql_query("TRUNCATE $databasetable");

// now insert the new recent data. Process Each Line
	while (!feof($file_handle) ) {

		$data = fgetcsv($file_handle);
		
		$Route = mysql_real_escape_string($data[0]);   // this function escapes  out the pesky apostrophe character (and double quuotes etc.

		$sql_insert = "insert into $databasetable ( Route, Activity, Start_Time, Time_normal, Time_normal_seconds, Time_stopped, Time_stopped_seconds, Distance, Average_speed, Average_pace, Average_pace_seconds, Climb, Calories, Fastest_speed, Fastest_pace, Fastest_pace_seconds, Notes)
		values ( '$Route', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]' ,'$data[6]' ,'$data[7]', '$data[8]', '$data[9]', '$data[10]' , '$data[11]', '$data[12]' , '$data[13]', '$data[14]', '$data[15]', '$data[16]' )";

			echo $data[0]."<br>";
		
		mysql_query($sql_insert);
	}
		
fclose($file_handle);
@mysql_close($con);
?>