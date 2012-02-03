<?php
function GChart_parse_type($prefix){
	return "cht=$prefix";
}

function GChart_parse_size($width, $height){
	return "chs={$width}x{$height}";
}

function GChart_parse_label($labels){
	return 'chl='.implode('|',$labels);
}

function GChart_parse_color($colors){
	return 'chco='.implode(',',$colors);
}

function GChart_parse_legend($legend){
	return 'chdl='.implode('|',$legend);
}

function GChart_parse_legend_position($pos){
	return 'chdlp='.$pos;
}

function GChart_parse_title($title){
	return 'chtt='.urlencode($title);
}

function GChart_parse_axis($axis_set){
	$param=array();
	$param[]=GChart_parse_axis_type($axis_set);
	if (GChart_is_set_axis_label($axis_set))
		$param[]=GChart_parse_axis_label($axis_set);
	if (GChart_is_set_axis_range($axis_set))
		$param[]=GChart_parse_axis_range($axis_set);
	
	return implode('&',$param);
}

/**
	Check whether or not a GChart_Axis object has labels
*/
function GChart_is_set_axis_label($axis_set){
	foreach ($axis_set as $a){
		if (!empty($a->labels))
			return true;
	}
	return false;
}

/**
	Check whether or not a GChart_Axis object's low and high boundry are set
*/
function GChart_is_set_axis_range($axis_set){
	foreach ($axis_set as $a){
		if (!empty($a->start)||!empty($a->end)){
			return true;
		}
	}
	return false;
}

function GChart_parse_axis_type($axis_set){
	$axis_type=array();
	foreach ($axis_set as $a){
		$axis_type[]=$a->type;
	}
	return 'chxt='.implode(',',$axis_type);
}

function GChart_parse_axis_label($axis_set){
	$axis=array();
	$count=count($axis_set);
	for ($i=0;$i<$count;++$i){
		$labels=array();
		foreach ($axis_set[$i]->labels as $l){
			$labels[]=$l->label;
		}
		if (!empty($labels))
			$axis[]=$i.':|'.implode('|',$labels);
	}
	return 'chxl='.implode('|',$axis);
}

function GChart_parse_axis_range($axis_set){
	$count=count($axis_set);
	$ranges=array();
	for ($i=0;$i<$count;++$i){
		if (isset($axis_set[$i]->start)&&isset($axis_set[$i]->end))
			$ranges[]=$i.','.$axis_set[$i]->start.','.$axis_set[$i]->end;
	}
	return 'chxr='.implode('|',$ranges);
}

function GChart_parse_scaling($data_set){
	$scaling_array=array();
	foreach ($data_set as $data){
		$scaling_array[]=$data->scale_min.','.$data->scale_max;
	}
	return 'chds='.implode(',',$scaling_array);
}

function GChart_parse_marker($data_set){
	$count_series=count($data_set);
	for ($s=0;$s<$count_series;++$s){
		$count_item=count($data_set[$s]->items);
		$p=array();
		for ($i=0;$i<$count_item;++$i){
			if (!empty($data_set[$s]->items[$i]->marker)){
				$m=$data_set[$s]->items[$i]->marker;
				$p=array(urlencode($m->type), $m->color, $s, $i, $m->size);
				if (!empty($m->priority))
					$p[]=$m->priority;
				$param[]=implode(',',$p);
			}
		}
	}
	if (!empty($param))
		return 'chm='.implode('|',$param);
	else
		return null;
}

function GChart_parse_background($background){
	$param=array();
	if (is_array($background)){
		foreach ($background as $bg)
			$param[]="$bg[2],$bg[1],$bg[0]";
	}
	return 'chf='.implode('|',$param);
}
?>
