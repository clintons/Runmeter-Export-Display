<?php
class GChart_Plot{
	var $pos_x;
	var $pos_y;
	var $size;
	
	function __construct($x, $y, $size=null){
		$this->pos_x=$x;
		$this->pos_y=$y;
		$this->size=$size;
	}
}
?>