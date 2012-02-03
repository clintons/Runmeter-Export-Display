<?php
/**
	GChart_Axis is the class for the chart axis.
*/

/**
	The following 4 definitions stand for 4 positions of an axis.
	The value will be passed to the finally URL.
*/
define ('GChart_BOTTOM_X_AXIS','x');
define ('GChart_TOP_X_AXIS','t');
define ('GChart_LEFT_Y_AXIS','y');
define ('Gchart_RIGHT_Y_AXIS','r');

require_once (GChart_CLASSES_DIR.'GChart_AxisLabel.php');

class GChart_Axis{
	var $id;
	var $name; // The name of the axis. It must be unique.
	var $type; // The type of the axis. Its value can be one of the four definitions above.
	var $labels=array(); // An axis can contains labels. For example, x-axis stands for months and it may have "Jan", "Feb", "Mar", etc.
	
	var $start; // The low value of the axis.
	var $end; // The high value of the axis.

	var $color;
	var $font_size;
	var $alignment;

	function __construct($type, $labels=array()){
		$this->type=$type;
		$this->set_labels($labels);
	}
	
	function set_boundry($low, $high){
		$this->start=$low;
		$this->end=$high;
	}
	
	/**
		set label of a chart. $labels is an array that contains some strings.
	*/
	function set_labels($labels){
		$this->labels=array();
		foreach ($labels as $label){
			$l=new GChart_AxisLabel($label);
			$this->labels[]=$l;
		}
	}
}
?>
