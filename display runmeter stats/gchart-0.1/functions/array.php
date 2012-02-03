<?php
function is_assoc($_array) {
    if (is_array($_array) == false) {
        return false;
    }
    foreach (array_keys($_array) as $k) {
        if (is_string($k)) {
            return true;
        }
    }
    return false;
}

function items_to_array($items){
	$arr=array();
	foreach ($items as $item){
		$arr[]=$item->value;
	}
	return $arr;
}
?>
