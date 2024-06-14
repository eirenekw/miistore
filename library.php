<?php

function autoNumber($id, $table){
	include "connect.php";
	$qry = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
	$result = mysqli_query($conn, $qry);
	$data = mysqli_fetch_array($result);
	$id_max = $data['max_id'];
	$sort_num = (int) substr($id_max, 1, 4);
	$sort_num++;
	$new_code = sprintf("%04s", $sort_num);
	return $new_code;
 }
 
 function toMoney($val, $symbol='$', $r = 2){
	$n = $val;
	$c = is_float($n) ? 1 : number_format($n, $r);
	$d = '.';
	$t = ',';
	$sign = ($n < 0) ? '-' : '';
	$i = $n = number_format(abs($n),$r);
	$j = (($j = strlen($i)) > 3) ? $j % 3 : 0;
							
	return $symbol.$sign.($j ? substr($i, 0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$i" + $t, substr($i, $j));
}

?>