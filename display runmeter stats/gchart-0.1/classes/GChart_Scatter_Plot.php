<?php
require_once (GChart_CLASSES_DIR.'GChart.php');
require_once (GChart_CLASSES_DIR.'GChart_Plot.php');

class GChart_Scatter_Plot extends GChart{
	var $type_prefix='s';
	var $data_set=array(); // stores GChart_Plot objects.
	var $axis_set=array();
	var $background=array();
	
	function set_background($color){
		$this->background[]=array($color,'s','bg');
	}
	
	function set_chart_background($color){
		$this->background[]=array($color,'s','c');
	}
	
	/**
		Add a plot into the scatter plot chart. $plot is an instance of GChart_Plot.
	*/
	function add_plot($plot){
		$this->data_set[]=$plot;
	}
	
	function parse_data(){
		$data_x=array();
		$data_y=array();
		$data_size=array();
		
		foreach ($this->data_set as $plot){
			$data_x[]=$plot->pos_x;
			$data_y[]=$plot->pos_y;
			if (!empty($plot->size))
				$data_size[]=$plot->size;
		}
		if (count($data_size)==count($data_x))
			$data=array($data_x,$data_y,$data_size);
		else
			$data=array($data_x,$data_y);
		
		foreach ($data as $d){
			$max=max($max,max($d));
		}
		switch ($this->encoding){
			case TEXT_ENCODING:
			case TEXT_ENCODING_SCALING:
				$data_arr=array();
				foreach ($data as $d){
					$data_s=implode(',',auto_encode($d,$this->encoding,$max));
					$data_arr[]=$data_s;
				}
				$encoded_string=implode('|',$data_arr);
				break;
			case SIMPLE_ENCODING:
			case EXTENDED_ENCODING:
				$data_arr=array();
				foreach ($data as $d){
					$data_s=implode('',auto_encode($d,$this->encoding,$max));
					$data_arr[]=$data_s;
				}
				$encoded_string=implode(',',$data_arr);
				break;
		}
		$data_string='chd='.$this->encoding_prefix.$encoded_string;
		if ($this->encoding==TEXT_ENCODING_SCALING)
			$data_string.='&'.GChart_parse_scaling($this->data_set);
		return $data_string;
	}
	
	function add_axis_by_type($type, $name='', $labels=array(), $start=null, $end=null){
		$axis=new GChart_Axis($type);
		if (!empty($labels)){
			foreach ($labels as $label){
				$axis_label=new GChart_AxisLabel($label);
				$axis->labels[]=$axis_label;
			}
		}
		if (!empty($name))
			$axis->name=$name;
		if (!empty($start)&&!empty($end)){
			$axis->start=$start;
			$axis->end=$end;
		}
		
		$this->axis_set[]=$axis;
	}
	
	function add_axis_by_object($axis){
		$this->axis_set[]=$axis;
	}
	
	function __call($method, $arg){
		switch ($method){
			case 'add_axis':
				if (is_a($arg[0],'GChart_Axis'))
					$this->add_axis_by_object($arg[0]);
				if (is_string($arg[0]))
					$this->add_axis_by_type($arg[0],$arg[1],$arg[2],$arg[3],$arg[4]);
				break;
		}
	}
	
	function get_axis_by_name($name){
		foreach ($this->axis_set as &$a){
			if ($a->name==$name){
				return $a;
			}
		}
		return false;
	}
	
	function get_image_string(){
		$param=array();

		$param[]=GChart_parse_type($this->type_prefix);
		if (!empty($this->title))
			$param[]=GChart_parse_title($this->title);
		$param[]=GChart_parse_size($this->width,$this->height);
		$param[]=$this->parse_data($this->data);
		if (!empty($this->axis_set))
			$param[]=GChart_parse_axis($this->axis_set);
		if (!empty($this->background)){
			$param[]=GChart_parse_background($this->background);
		}

		return GChart_URL.'?'.implode('&',$param);
	}
}
?>