<?php
require_once (GChart_CLASSES_DIR.'GChart.php');

class GChart_GOM extends GChart{
	var $type_prefix='gom';
	var $scale_min=0;
	var $scale_max=100;
	
	var $data=array();
	
	function set_scaling($min, $max){
		$this->scale_min=$min;
		$this->scale_max=$max;
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
		foreach ($this->data as $d){
			$value_set[]=$d->value;
			$label_set[]=$d->label;
			if (!empty($d->color))
				$color_set[]=$d->color;
		}
		
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

		return GChart_URL.'?'.implode('&',$param);
	}
}
?>
