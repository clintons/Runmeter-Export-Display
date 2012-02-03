<?php
require_once (GChart_CLASSES_DIR.'GChart_Marker.php');

class GChart_DataItem{
	var $id;
	var $name;
	var $value;
	var $label;
	var $color;
	var $marker;
	private static $count=0;

	function __construct($value, $name=''){
		$this->value=$value;
		$this->id=self::$count;
		self::$count++;

		if (!empty($name)){
			$this->name=$name;
		}
	}
	
	function set_marker($marker){
		$this->marker=$marker;
	}

	function __get($name){
		return $this->$name;
	}

	function __set($name, $value){
		$this->$name=$value;
	}
}
?>
