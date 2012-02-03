<?php
if (!defined('GChart_DIR'))
	die('GChart_DIR is undefined. Its value should be the path of GChart directory.');
define ('GChart_CLASSES_DIR',GChart_DIR.'/classes/');
define ('GChart_FUNCTIONS_DIR',GChart_DIR.'/functions/');

define ('GChart_URL','http://chart.apis.google.com/chart');

define ('GChart_LEGEND_BOTTOM','b');
define ('GChart_LEGEND_TOP','t');
define ('GChart_LEGEND_RIGHT','r');
define ('GChart_LEGEND_LEFT','l');

require_once (GChart_FUNCTIONS_DIR.'parse.php');
require_once (GChart_FUNCTIONS_DIR.'encoding.php');
require_once (GChart_CLASSES_DIR.'GChart_Pie2D.php');
require_once (GChart_CLASSES_DIR.'GChart_Pie3D.php');
require_once (GChart_CLASSES_DIR.'GChart_Bar_H.php');
require_once (GChart_CLASSES_DIR.'GChart_Bar_V.php');
require_once (GChart_CLASSES_DIR.'GChart_Line.php');
require_once (GChart_CLASSES_DIR.'GChart_QR.php');
require_once (GChart_CLASSES_DIR.'GChart_GOM.php');
require_once (GChart_CLASSES_DIR.'GChart_Radar.php');
require_once (GChart_CLASSES_DIR.'GChart_Scatter_Plot.php');
?>
