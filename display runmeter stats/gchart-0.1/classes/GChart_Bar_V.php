<?php
require_once (GChart_CLASSES_DIR.'GChart_Bar.php');

class GChart_Bar_V extends GChart_Bar{
	var $type_prefix='bvs';
	
	function __construct($width, $height, $grouped=false){
		parent::__construct($width, $height);
		if ($grouped)
			$this->type_prefix='bvg';
	}
}
?>
