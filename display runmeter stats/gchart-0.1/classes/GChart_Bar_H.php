<?php
require_once (GChart_CLASSES_DIR.'GChart_Bar.php');

class GChart_Bar_H extends GChart_Bar{
	var $type_prefix='bhs';
	
	function __construct($width, $height, $grouped=false){
		parent::__construct($width, $height);
		if ($grouped)
			$this->type_prefix='bhg';
	}
}
?>
