<?php
function auto_encode($data_series, $encoding, $m=null){
	switch ($encoding){
		case TEXT_ENCODING:
			return text_encode($data_series,$m);
		case TEXT_ENCODING_SCALING:
			return $data_series;
		case SIMPLE_ENCODING:
			return simple_encode($data_series,$m);
		case EXTENDED_ENCODING:
			return extended_encode($data_series,$m);
	}
}

function text_encode($data,$m=null){
	$max=max($data);
	if (!empty($m))
		$max=$m;
	
	// Because text encoding can not support the value which is greater 100. If the max value is greater the 100, we should choose a number to divide each of the numbers.
	if ($max>100){
		$rate=$max/100.0;
		foreach ($data as &$elem){
			$elem/=$rate;
		}
	}
	
	// If GChart_DECIMALS is defined, applies 'number_format' to format the number.
	if (defined('GChart_DECIMALS')){
		foreach ($data as &$elem){
			$elem=number_format($elem,GChart_DECIMALS);
		}
	}
	return $data;
}

function simple_encode($data){
	$encode_string='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$max=max($data);
	if (!empty($m))
		$max=$m;
	if ($max>61){
		$rate=$max/61.0;
		foreach ($data as &$elem){
			$elem=(int)$elem/$rate;
			$elem=$encode_string[$elem];
		}
	}else{
		foreach ($data as &$elem){
			$elem=$encode_string[(int)$elem];
		}
	}
	return $data;
}

function extended_encode($data){
	$encode_string='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.';
	$max=max($data);
	if (!empty($m))
		$max=$m;
	if ($max>4095){
		$rate=$max/4095.0;
		foreach ($data as &$elem){
			$elem=(int)$elem/$rate;
			$s='';
			for ($i=0;$i<2;++$i){
				$m=$elem%64;
				$elem/=64;
				$s=$encode_string[$m].$s;
			}
			$elem=$s;
		}
	}else{
		foreach ($data as &$elem){
			$s='';
			for ($i=0;$i<2;++$i){
				$m=$elem%64;
				$elem/=64;
				$s=$encode_string[$m].$s;
			}
			$elem=$s;
		}
	}
	return $data;
}
?>
