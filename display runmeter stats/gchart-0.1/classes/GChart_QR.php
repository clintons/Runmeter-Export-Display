<?php
define ('GChart_QR_SHIFT_JIS','Shift_JIS');
define ('GChart_QR_UTF-8','UTF-8');
define ('GChart_QR_ISO-8859-1','ISO-8859-1');

require_once (GChart_CLASSES_DIR.'GChart.php');

class GChart_QR extends GChart{
	var $type_prefix='qr';
	var $text;
	var $output_encoding;
	
	function set_text($text){
		$this->text=$text;
	}
	
	function set_char_encoding($encoding){
		$this->output_encoding=$encoding;
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
	
	function parse_data(){
		$param=array("chl={$this->text}");
		if (!empty($this->output_encoding)){
			$param[]="choe={$this->output_encoding}";
		}
		return implode('&',$param);
	}
}
?>
