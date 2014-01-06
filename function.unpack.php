<?php

// function unpack
function unpacker($pack) {
	
	// check string length
	if(strlen($pack) < 1) {
		die("empty string...");
	}

	// we search the "packer" prototype
	$proto = "eval(function(p,a,c,k,e,r)";
	if(substr(trim($pack), 0, strlen($proto)) != $proto) {
		die("it does'nt seems to be a p,a,c,k,e,r function...");
	}

	// grab the parameters
	$preg = "@}\('(.*)', *(\d+), *(\d+), *'(.*)'\.split@";	
	preg_match_all($preg, $pack, $match, PREG_SET_ORDER);
	$match = $match[0];
	
	// functions
	$_f = $match[1];
	
	// base (62, 95...)
	$_b = $match[2];
	
	// max functions in this pack
	$_m = $match[3];
	
	// keywords
	$_k = explode("|",$match[4]);

	// check if we have all the keywords
	if(count($_k) != $_m) {
		die("it seems that the functions (".count($_k).") are different (".$_m.").");
	}

	// if base > 62, we can't work (actually...)
	if($_b > 62) {
		die("you try to parse a ".$_b." base...");
	}

	// base 62
	$_p = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	// max iterations
	$i = intval($_m/62) + 1;
	
	// init array
	$_t = array();
	
	// building function array
	for($j=0; $j<$i; $j++) {
		for($k=0; $k<62; $k++) {
			$l = substr($_p,$k,1);
			$n = 62*$j+$k;
			if($j > 0) $l = $j.substr($_p,$k,1);
			if($n < $_m) $_t[$l] = $_k[$n];
		}
	} 

	// now we have an array (_t) with all the function with key

	// we search all masked functions
	$preg = "/[a-zA-Z0-9]+\b/";
	preg_match_all($preg, $_f, $match);
	$match = $match[0];

	// remplacement dans la fonction
	$str = $_f;
	foreach($match as $d) {
		if($_t[$d] != '') {
			// we replace only masked functions
			$str = preg_replace("/\b".$d."\b/", $_t[$d], $str);
		}
	}
	
	// $str is the new complete function;
	return $str;
	
}
