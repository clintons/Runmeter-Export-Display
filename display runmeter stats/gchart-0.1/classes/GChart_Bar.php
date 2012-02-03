<?php
require_once (GChart_CLASSES_DIR.'GChart.php');
require_once (GChart_CLASSES_DIR.'GChart_DataSeries.php');
require_once (GChart_CLASSES_DIR.'GChart_Axis.php');
require_once (GChart_FUNCTIONS_DIR.'parse.php');
require_once (GChart_FUNCTIONS_DIR.'encoding.php');
require_once (GChart_FUNCTIONS_DIR.'array.php');

/**
	Since there are 2 kinds of bar charts. The GChart_Bar class is abstract. You can not use this class directly.
	You should use:
		GChart_Bar_V: vertical bar chart
		GChart_Bar_H: horizontal bar chart
*/
abstract class GChart_Bar extends GChart{
	var $type_prefix;
	var $data_set=array(); // stores data. The elements are GChart_DataSeries objects, which contains a group of data. i.e. bar charts can maintains several groups of data.
	var $legend_position;
	
	var $axis_set=array();
	
	var $bar_width; // The width of a bar.
	var $bar_space; // The width between two bars in one group.
	var $group_space; // The width between two groups.
	
	var $background=array(); // The image background or the chart background.
	
	function set_background($color){
		$this->background[]=array($color,'s','bg');
	}
	
	function set_chart_background($color){
		$this->background[]=array($color,'s','c');
	}
	
	function set_bar_width($width, $space=null, $group_space=null){
		$this->bar_width=$width;
		if (!empty($space))
			$this->bar_space=$space;
		if (!empty($group_space))
			$this->group_space=$group_space;
	}
	
	function add_array($data_set, $label='', $color=''){
		$series=new GChart_DataSeries();
		$series->set_items($data_set);
		if (!empty($label))
			$series->label=$label;
		if (!empty($color))
			$series->color=$color;
		
		$this->data_set[]=$series;
	}
	
	function add_series($series){
		$this->data_set[]=$series;
	}
	
	function __call($name, $p){
		switch ($name){
			case 'add':
				if (is_a($p[0],'GChart_DataSeries')){
					$this->add_series($p[0]);
				}
				if (is_array($p[0])){
					$this->add_array($p[0],$p[1],$p[2]);
				}
				break;
			case 'add_axis':
				if (is_a($p[0],'GChart_Axis'))
					$this->add_axis_by_object($p[0]);
				if (is_string($p[0]))
					$this->add_axis_by_type($p[0],$p[1],$p[2],$p[3],$p[4]);
				break;
		}
	}
	
	function get_series_by_label($label){
		foreach ($this->data_set as &$data){
			if ($data->label==$label)
				return $data;
		}
		return false;
	}
	
	function get_series_by_index($index){
		return $this->data_set[$index];
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
	
	function get_axis_by_name($name){
		foreach ($this->axis_set as &$a){
			if ($a->name==$name){
				return $a;
			}
		}
		return false;
	}
	
	function parse_data(){
		$data=array();
		$color_set=array();
		$label_set=array();
		foreach ($this->data_set as $d){
			$data[]=items_to_array($d->items);
			if (!empty($d->color))
				$color_set[]=$d->color;
			$label_set[]=$d->label;
			$max=max($max,max($d->get_value_set()));
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
		if (!empty($label_set)){
			$data_string.='&'.GChart_parse_legend($label_set);
		}

		if (!empty($color_set))
			$data_string.='&'.GChart_parse_color($color_set);
		return $data_string;
	}
	
	function parse_bar_width($bar_width, $bar_space, $group_space){
		$param=array();
		$param[]=$bar_width;
		if (!empty($bar_space))
			$param[]=$bar_space;
		if (!empty($group_space))
			$param[]=$group_space;
		return 'chbh='.implode(',',$param);
	}
	
	function get_image_string(){
		$param=array();

		$param[]=GChart_parse_type($this->type_prefix);
		if (!empty($this->title))
			$param[]=GChart_parse_title($this->title);
		$param[]=GChart_parse_size($this->width,$this->height);
		$param[]=$this->parse_data($this->data);
		if (!empty($this->bar_width))
			$param[]=$this->parse_bar_width($this->bar_width, $this->bar_space, $this->group_space);
		if (!empty($this->axis_set))
			$param[]=GChart_parse_axis($this->axis_set);
		if (!empty($this->legend_position))
			$param[]=GChart_parse_legend_position($this->legend_position);
		if (!empty($this->background)){
			$param[]=GChart_parse_background($this->background);
		}
		$markers=GChart_parse_marker($this->data_set);
		if (!empty($markers))
			$param[]=$markers;
		
		return GChart_URL.'?'.implode('&',$param);
	}
}
?>
