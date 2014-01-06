<?php

// make some spaces...
function makespaces($j) {
	$m = $j*4; // 1 tab = 2 spaces
	for($i=0; $i<$m; $i++) 
		echo ' ';
}

// we try to indent the code
function echo_packer($str) {

	$str = str_replace("\\'", "'", $str);
	$str = str_replace('\\', '', $str);

	// we don't eval the code...
	$str = htmlentities($str);
	
	echo PHP_EOL;
	
	$_of = 0; // fonction
	$_ov = 0; // ;
	$_op = 0; // (
	$_oc = 0; // {
	$_oe = 0; // &
	$_og = 0; // "
	$_ob = 0; // block if, for, while...
	$_oi = 0; // indentation
	

	// char by char...
	for($i = 0; $i < strlen($str); $i++) {

		$c = substr($str, $i, 1);
		
		if(substr($str, $i, 3) == 'for') {
			$_ob = 1;
		}
		if($_ob && $c == ')') {
			$_ob = 0;
		}
		if($c == '(') {
			$_op++;
		}
		if($c == ')') {
			$_op--;
			if($_op < 0) $_op = 0;
		}
		if($c == "&") {
			$_oe = 1;
			if(substr($str, $i, 6) == '&quot;') {
				$_og = !$_og;
			}
		}
		if($c == '}') {
			echo PHP_EOL;
			$_oi--;
			makespaces($_oi);
		}
		
		// on affiche le caractère
		echo $c;
		
		if($c == ',' && !$_op) {
			echo PHP_EOL;
			makespaces($_oi);
		}
		if($c == ';' && !$_ob && !$_oe && !$_og) {
			echo PHP_EOL;
			makespaces($_oi);
		}
		if($c == '{') {
			echo PHP_EOL;
			$_oi++;
			makespaces($_oi);
		}
		if($c == '}' && substr($str, $i+1, 1) != ';' && substr($str, $i+1, 1) != ')' && substr($str, $i+1, 4) != 'else' && substr($str, $i+1, 5) != 'catch') {
			echo PHP_EOL;
			makespaces($_oi);
		}
				
		if($c == ';' && $_oe) {
			$_oe = 0;
		}
	}

}
 