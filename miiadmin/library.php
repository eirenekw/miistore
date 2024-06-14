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
 
 function fixdate($date) {
	 return date('d-m-Y', strtotime($date));
 }
 ?>