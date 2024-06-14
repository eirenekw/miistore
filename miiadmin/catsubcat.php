<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once("connect.php");

session_start();

if(isset($_COOKIE['user']) && $_COOKIE['user'] != ''){
	$name = $_COOKIE['fullname'];
}else if(isset($_SESSION['user']) && $_SESSION['user'] != ''){
	$name = $_SESSION['fullname'];
}else{
	header('location: index.php');
	exit();
}
?>
<div class="catsubcat" style="margin-top: 7%; margin-bottom: 10%;">
	<div class="table-responsive">
		<table class="table table-bordered results">
			<thead>
				<tr>
					<th width="10">#</th>
					<th>Tanggal</th>
					<th>Gambar</th>
					<th>Produk</th>
					<th>Harga</th>
					<th>Diskon</th>
					<th>Harga Diskon</th>
					<th>Stok</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$search = $_GET['s'];
			$sql = "SELECT * FROM items INNER JOIN colors ON colors.clr_id = items.clr_id INNER JOIN brands ON brands.brd_id = items.brd_id INNER JOIN categories ON 
					 categories.cat_id = items.cat_id INNER JOIN subcategories ON subcategories.scat_id = items.scat_id WHERE items.scat_id = '".$search."'";
			$query = mysqli_query($conn, $sql);
			$no = 0;
			while($row = mysqli_fetch_array($query)){
				$totalDisc = $row['price']-($row['price'] * $row['discount']/100);
				$total1 = $total1 + $totalDisc;
				$total2 = $total2 + $row['stock'];
				$date = $row['creation_date'];
				$date_detail = date('d-m-Y', strtotime($date));
			?>
				<tr>
					<td width="10" align="center"><?php echo ++$no; ?></td>
					<td align="center"><?php echo $date_detail; ?></td>
					<td align="center"><img src="img/<?php echo $row['bgimg']; ?>" style="width: 80px; display: block;"></td>
					<td>
						Kode : <?php echo $row['item_id']; ?><br/>
						Nama : <?php echo $row['item_name']; ?><br/>
						Warna : <?php echo $row['color']; ?><br/>
						Ukuran : <?php echo $row['size']; ?><br/>
						Brand : <?php echo $row['brand']; ?><br/>
						Kategori : <?php echo $row['category']; ?><br/>
						Subkategori : <?php echo $row['subcategory']; ?><br/>
					</td>
					<td align="center"><?php echo 'Rp '.number_format($row['price'],0,".","."); ?></td>
					<td align="center"><?php echo $row['discount']; ?>%</td>
					<td align="center"><?php echo 'Rp '.number_format($totalDisc,0,".","."); ?></td>
					<td align="center"><?php echo $row['stock']; ?></td>
				</tr>
			<?php } ?>
				<tr>
					<td colspan="6" align="right">Total</td>
					<td align="center"><?php echo 'Rp '.number_format($total1,0,".","."); ?></td>
					<td align="center"><?php echo $total2; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<button type="button" class="btn btn-default" onclick="window.open('pdf/item_catsubcat_report_bypdf.php?scat=<?php echo $_GET['s']; ?>');"> Lihat PDF</button>
</div>