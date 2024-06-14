<div id="divToPrint">
	<div class="container">
		<div class="row">
			<div class="col-xs-6">
				<img class="logo-img" src="../logo/miistore1.png" />
			</div>
			<div class="col-xs-6 text-right"  style="margin-top: 20px;">
				<address>
				Jl. Raya Condet Jakarta Timur<br/>
				Telepon : 021 23456789<br/>
				Email : info@example.com
				</address>
			</div>
				<?php 
				if(isset($_SESSION['order_id'])){
					$date_detail = '';
					$cust_detail = '';
					$payment_detail = '';
					$total = 0;
					$query = "SELECT * FROM orders INNER JOIN members ON members.member_id = orders.customer_id WHERE orders.order_id = '".$_SESSION['order_id']."'";
					$result = mysqli_query($conn, $query);
					while($row = mysqli_fetch_array($result)){
						
						$date = ''.$row['creation_date'].'';
						$date_detail = date('d-m-Y', strtotime($date));
						
						$time_detail = ''.$row['creation_time'].'';
						
						$cust_detail = '
						'.$row['fullname'].'<br/>
						'.$row['address'].'<br/>
						'.$row['city'].'<br/>
						'.$row['state'].'<br/>
						'.$row['zip_code'].'<br/>
						Telp '.$row['phone'].'
						';
						$payment_detail = '
						'.$row['owner_name'].'<br/>
						'.$row['cardbank_type'].'<br/>
						'.$row['card_number'].'<br/>
						';
					}
				}
				?>
			<div class="col-xs-12 text-center">
				<h3>Bukti Konfirmasi Pembayaran</h3>
				<center><h5>Nomor Pemesanan : <?php echo $_SESSION['order_id']; ?></h5></center>
			</div>
			<hr>
		</div>
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xs-6">
				<strong>Alamat Pemesanan</strong>
				<address>
				<?php echo $cust_detail; ?>
				</address>
			</div>
			<div class="col-xs-6 text-right">
				<strong>Tanggal Pemesanan</strong><br/>
				<?php echo $date_detail; ?>
				<?php echo $time_detail; ?>
			</div>
			<div class="col-xs-6 text-right">
				<strong>Detail Pembayaran</strong><br/>
				<?php echo $payment_detail; ?>
			</div>
		</div>
		<div class="col-lg-12">
			<table class="timetable_sub">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Jumlah</th>
						<th>Diskon</th>
						<th>Harga</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<?php
				$query = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = '".$_SESSION['order_id']."'");
				$no = 1;
				while($row = mysqli_fetch_array($query)){
					$totalDisc = $row['price']-($row['price'] * $row['disc']/100);
					$subtotal = $row['qty'] * $totalDisc;
					$total = $total + $subtotal;
				?>
				<tr>
					<td align="center"><?php echo $no; ?></td>
					<td>
						<div class="table-column-left">
							<img src="../miiadmin/img/<?php echo $row['bgimg']; ?>" class="img-small">
						</div>
						<div class="table-column-right">
							Kode : <?php echo $row['item_code']; ?><br/>
							Nama : <?php echo $row['item_name']; ?><br/>
							Color : <?php echo $row['color']; ?><br/>
							Size : <?php echo $row['size']; ?><br/>
						</div>
					</td>
					<td align="center"><?php echo $row['qty']; ?></td>
					<td align="center"><?php echo $row['disc']; ?>%</td>
					<td align="center"><?php echo 'Rp '.number_format($row['price'],0,".","."); ?></td>
					<td align="center"><?php echo 'Rp '.number_format($subtotal,0,".","."); ?></td>
				</tr>
				<?php
				$no++;
				}
				?>
				<tr>
					<td colspan="5" align="right">Total</td>
					<td align="center"><?php echo 'Rp '.number_format($total,0,".","."); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="container" style="margin-bottom:20px;">
	<div class="shopping-right-basket">
		<form action="../index.php?p=order" method="POST">
		<input type="button" value="Print" class="btn-continue" onclick="PrintDiv('divToPrint')">
		<input type="submit" name="finish" value="Selesai" class="btn-continue">
		</form>
	</div>
	<?php
	if(isset($_POST['finish'])){
		unset($_SESSION['order_id']);
		echo "<script>document.location = '../index.php'; </script>";
	}
	?>
</div>
