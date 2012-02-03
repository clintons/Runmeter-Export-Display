<html>
<head>
 
</head>
<body>
<?php
/********************************/
/* Code from http://strombotne.com/
/* The query in this file is for PHP5 only
/* If you use this code, find a flaw, enhance or otherwise improve it then please let me know
/* via comment or link.
/********************************/

include ('query_count_events_last_30.php');
include ('query_pace.php');
include ('query_distance_all.php');
include ('graph_daily_distance.php');
include ('query_distance_last_7.php');
?> 
<center>
<img src="http://chart.apis.google.com/chart?cht=p3&chs=375x125&chd=t:<?php echo $event_count.','.$days_off.'&chl='.$event_count.'+Days+Run|Days+Off&chtt=Last+30+Days';?>">
<!-- uses query_count_events_last_30.php -->
<br><br><br>
<img src="http://chart.apis.google.com/chart?chxl=0:|faster||slower&chxt=y&chs=375x125&cht=gm&chds=400,1000&chd=t:<?php echo $Pace2.'&chl='.$Pace1; ?>&chtt=Pace&meter.png">
<!-- uses query_pace.php -->
<br><br><br>
<img src="http://chart.apis.google.com/chart?chxr=0,0,1000&chbh=18,0,16&chs=375x70&cht=bhs&&chco=C6D9FD&chds=0,1000&chd=t:<?php echo $distance_total_r.'&chtt='.$distance_total_r.'+Miles+Jogging'; ?>" width="450" height="70" alt="Miles Run" />
<!-- uses query_distance_all.php -->
<br><br>
<img src="http://chart.apis.google.com/chart?chxr=0,0,1000&chxt=x&chbh=18,0,16&chs=375x70&cht=bhs&&chco=76A4FB&chds=0,1000&chd=t:<?php echo $distance_total_w.'&chtt='.$distance_total_w.'+Miles+Walking'; ?>" width="450" height="70" alt="Miles Run" />
<!-- uses query_distance_all.php -->
<br><br><br>
<img src='<?php echo $url; ?>' /> 
<!-- from graph_daily_distance.php -->
<br><br>
<span style="color:gray; font-family:arial, sans-serif"><?php echo $distance_7.' miles run this week (about '.$distance_per_day.' miles per day on average)'; ?></span>
<!-- uses query_distance_last_7.php -->
</center>
</body>
</html>