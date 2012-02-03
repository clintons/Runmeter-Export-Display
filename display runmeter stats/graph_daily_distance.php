<?php
 require_once ("../dbinfo.inc.php");
/********************************/
/* Code from http://strombotne.com/
/* The query in this file is for PHP5 only
/* If you use this code, find a flaw, enhance or otherwise improve it then please let me know
/* via comment or link.
/********************************/

 $db = new mysqli($databasehost,$databaseusername,$databasepassword,$databasename);

    if ($db->connect_error) {
        die('Connect failed: ' . $db->connect_error);
    }

    if (!$db->set_charset("utf8")) {
        die('Error loading character set utf8: ' . $db->error);
    }
    $sql="SELECT DAYOFMONTH(Start_Time) AS EventDate, Distance FROM $databasetable WHERE Activity = 'run' AND DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= Start_Time";
    $url = 'http://chart.apis.google.com/chart?';
    $point_size = 3;
    $data = array(
        'cht' => 'bvg',
	'chtt'=>'Miles Run|Distance and Date',
        'chxt' => 'y,x',
        'chs' => '650x300',
	'chco' => 'A2C180',
	'chd' => 't:',
        'chxr' => '0,0,6',
        'chds' => '0,6',
        'chxl' => '1:|'
    );
    $chxl = array();
    $chd = array(
        'x'=> array(), 
        'y' => array()
    );

    if ($stmt = $db->prepare($sql)) {
        /* execute query */
        if ($stmt->execute() === true) {
                /* bind result variables */
                $stmt->bind_result($EventDate, $distance);

                /* fetch values */
                while ($stmt->fetch()) {
                        array_push($chd['x'], $EventDate);
                        array_push($chd['y'], $distance);
			
                }
        } else {
                die('stmt error: ' . $stmt->error);
        }

        /* free result */
        $stmt->free_result();

        /* close statement */
        $stmt->close();
    } else {
        die('Cannot prepare stmt: ' . $db->error);
    }

    $db->close();

    $data['chxl'] .= implode($chd['x'], ' | ');
   // $data['chxl'] .= implode($chd['x'], ' | ');
    $data['chd']  .= implode($chd['y'], ',');
    $data['chxr'];
    $data['chds'];
    $url .= http_build_query($data, '', '&amp;'); // http_build_query is PHP5 only
?>