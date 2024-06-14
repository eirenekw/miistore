<?php
	include "connect.php";
	$cat = $_GET['catid'];
	$query = mysqli_query($conn, "SELECT * FROM subcategories WHERE cat_id = '$cat' ORDER BY subcategory ASC");
	echo '<option value="blank">-- Pilih jenis subkategori --</option>';
	while($scat = mysqli_fetch_array($query)){
		echo "<option value='$scat[scat_id]'".($_GET['scat_id'] == $scat['scat_id'] ? 'selected' : null).">$scat[subcategory]</option>";
	}
?>