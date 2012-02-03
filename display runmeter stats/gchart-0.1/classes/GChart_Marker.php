<?php
/**
	GChart_Marker class is used for mark a special data point.
*/
require_once (GChart_DIR.'/GChart.php');

define ('GChart_M_ARROW','a');
define ('GChart_M_CROSS','c');
define ('GChart_M_DIAMOND','d');
define ('GChart_M_CIRCLE','o');
define ('GChart_M_SQUARE','s');
define ('GChart_M_TEXT','t');
define ('GChart_M_VLINE_X','v');
define ('GChart_M_VLINE_T','V');
define ('GChart_M_HLINE','h');
define ('GChart_M_X','x');

class GChart_Marker{
	var $type;
	var $color;
	var $size;
	var $priority;
	
	function __construct($type, $color, $size, $priority=null){
		$this->type=$type;
		$this->color=$color;
		$this->size=$size;
		$this->priority=$priority;
	}
}
?>
