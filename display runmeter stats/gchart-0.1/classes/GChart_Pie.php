<?php
require_once(GChart_CLASSES_DIR.'GChart.php');
require_once(GChart_CLASSES_DIR.'GChart_DataItem.php');

abstract class GChart_Pie extends GChart{
	var $type_prefix; // indicates the type of the chart. 2D pie is 'p' and 3D pie is 'p3'
	var $data=array(); // stores the data
	var $color_set=array(); // store the colors. It is used by the 'add_color()' method.
	
	// The following two attributes set the low and the high boundry if the use set the data encoding to "text encoding with data scaling".
	var $scale_min=0;
	var $scale_max=100;
	
	var $background=array(); // stores the background color
	
	function set_background($color){
		$this->background[]=array($color,'s','bg');
	}
	
	function set_scaling($min, $max){
		$this->scale_min=$min;
		$this->scale_max=$max;
	}
	
	// If a user use 'add(array)' to add the data, he can use 'add_color' to set the data items' colors
	function add_color($color){
		if (is_string($color)){
			$this->color_set[]=$color;
		}
		if (is_array($color)){
			$this->color_set=array_merge($this->color_set, $color);
		}
	}
	
	function __call($method, $p){
		switch ($method){
			case 'add':
				if (is_array($p[0]))
					$this->add_array($p[0]);
				else
					$this->add_item($p[0],$p[1],$p[2]);
			break;
		}
	}
	
	// For a pie chart, each data item may have its own label and color. So you can use the last two arguments to set them. They are optional.
	function add_item($value, $label='', $color=''){
		$item=new GChart_DataItem($value);
		if (!empty($label))
			$item->label=$label;
		if (!empty($color))
			$item->color=$color;
			
		$this->data[]=$item;
	}
	
	function add_array($arr){
		if (is_assoc($arr)){
			foreach ($arr as $k=>$v){
				$item=new GChart_DataItem($v);
				$item->label=$k;
				$this->data[]=$item;
			}
		}else{
			foreach ($arr as $elem){
				$item=new GChart_DataItem($elem);
				$this->data[]=$item;
			}

		}
	}

	function parse_data(){
		$value_set=array();
		$label_set=array();
		$color_set=array();
		foreach ($this->data as $d){
			$value_set[]=$d->value;
			$label_set[]=$d->label;
			if (!empty($d->color))
				$color_set[]=$d->color;
		}
		$color_set=array_merge($color_set, $this->color_set);
		
		switch ($this->encoding){
			case TEXT_ENCODING:
			case TEXT_ENCODING_SCALING:
				$encoded_string=implode(',',auto_encode($value_set,$this->encoding));
				break;
			case SIMPLE_ENCODING:
			case EXTENDED_ENCODING:
				$encoded_string=implode('',auto_encode($value_set,$this->encoding));
				break;
		}

		$data_string='chd='.$this->encoding_prefix.$encoded_string;
		if ($this->encoding==TEXT_ENCODING_SCALING)
			$data_string.="&chds={$this->scale_min},{$this->scale_max}";
		if (!empty($label_set)){
			$data_string.='&'.GChart_parse_label($label_set);
		}

		if (!empty($color_set))
			$data_string.='&'.GChart_parse_color($color_set);
		return $data_string;
	}
	
	function get_image_string(){
		$param=array();

		$param[]=GChart_parse_type($this->type_prefix);
		if (!empty($this->title))
			$param[]=GChart_parse_title($this->title);
		$param[]=GChart_parse_size($this->width,$this->height);
		$param[]=$this->parse_data($this->data);
		if (!empty($this->background)){
			$param[]=GChart_parse_background($this->background);
		}

		return GChart_URL.'?'.implode('&',$param);
	}
}
?>