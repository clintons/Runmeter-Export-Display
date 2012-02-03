<?php
require_once (GChart_DIR.'/GChart.php');
require_once (GChart_CLASSES_DIR.'GChart_DataItem.php');

class GChart_DataSeries{
	var $id;
	var $name;
	var $label;
	var $color;
	var $scale_min=0;
	var $scale_max=100;

	var $items;
	
	/**
		Constructor. $item is an array, $label and $color are strings. If all the arguments are omitted, you should use "set_items()" to set the data.
	*/
	function __construct($items=null, $label=null, $color=null){
		if (!empty($items))
			$this->set_items($items);
		$this->label=$label;
		$this->color=$color;
	}
	
	function set_scaling($min, $max){
		$this->scale_min=$min;
		$this->scale_max=$max;
	}
	
	function set_items($items, $label=null, $color=null){
		$this->items=array();
		foreach ($items as $item){
			$new_item=new GChart_DataItem($item);
			$this->items[]=$new_item;
		}
		$this->label=$label;
		$this->color=$color;
	}
	
	function get_item_by_index($index){
		return $this->items[$index];
	}
	
	function get_value_set(){
		$set=array();
		foreach ($this->items as $item){
			$set[]=$item->value;
		}
		return $set;
	}
	
	function get_data($index){
		return $this->items[$index];
	}
	
	function __get($name){
		return $this->$name;
	}

	function __set($name, $value){
		$this->$name=$value;
	}

	function add_item($item){
		$items[]=$item;
	}
}
?>