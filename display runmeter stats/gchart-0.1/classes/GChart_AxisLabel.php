<?php
class GChart_AxisLabel{
	var $label;
	var $position;

	function __construct($label){
		$this->label=$label;
	}

	function __get($name){
		return $this->$name;
	}

	function __set($name, $value){
		$this->$name=$value;
	}
}
?>
