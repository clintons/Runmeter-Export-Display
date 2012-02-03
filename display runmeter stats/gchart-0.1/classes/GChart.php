<?php
require_once (GChart_FUNCTIONS_DIR.'array.php');

/**
	Google Chart API accepts for kinds of data encoding.
	They are: text encoding (with or without data scaling), simple encoding and extended encoding. See Google Chart API's official document.
*/
define ('TEXT_ENCODING','TEXT_ENCODING');
define ('TEXT_ENCODING_SCALING','TEXT_ENCODING_SCALING');
define ('SIMPLE_ENCODING','SIMPLE_ENCODING');
define ('EXTENDED_ENCODING','EXTENDED_ENCODING');

abstract class GChart{
	var $title; // The title of the chart, optional.
	var $width; // The width of the chart image.
	var $height; // The height of the chart image.
	var $type;
	
	var $encoding='TEXT_ENCODING'; // The default data encoding is text encoding.
	var $encoding_prefix='t:'; // This is the string to be passed to Google, means "text encoding".
	
	function __construct($width, $height){
		$this->set_size($width, $height);
	}
	
	function set_title($title){
		$this->title=$title;
	}

	function set_size($width, $height){
		$this->width=$width;
		$this->height=$height;
	}
	
	/**
		Set the data encoding.
	*/
	function set_encoding($encoding){
		$this->encoding=$encoding;
		switch ($encoding){
			case TEXT_ENCODING:
				$this->encoding_prefix='t:';
				break;
			case TEXT_ENCODING_WITH_SCALING:
				$this->encoding_prefix='t:';
				break;
			case SIMPLE_ENCODING:
				$this->encoding_prefix='s:';
				break;
			case EXTENDED_ENCODING:
				$this->encoding_prefix='e:';
				break;
		}
	}
	
	function __set($name, $value){
		$this->$name=$value;
	}
	
	function __get($name){
		return $this->$name;
	}
	
	/**
		return the image's URL. Normally, the value is passwd to <img src="..." /> to show the image.
	*/
	abstract function get_image_string();
}
?>