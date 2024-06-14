<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once("connect.php");

session_start();

if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != ''){
	$id = $_COOKIE['user_id'];
}else if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
	$id = $_SESSION['user_id'];
}else{
	header('location: index.php');
	exit();
}

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MiiStore | Pesanan</title>
	<meta name="keywords" content="men, women, clothing, home" />
	<meta name="author" content="Victory Webstore"/>
	
	<!-- mobile specific -->
	<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="../logo/miistore-favicon.png" />
	
	<!-- CSS Offline -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/miiadmin.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
	<style type="text/css" media="print">
	@page { size: portrait; }
	</style>
</head>
<body>
	<?php
	$queryname = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '".$id."'");
	$name = mysqli_fetch_array($queryname);
	?>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="#main-toggle" id="menu-toggle" class="sidebar-toggle">
					<span class="sr-only">Toggle Navigation</span>
				</a>
				<a href="#" class="navbar-brand"><img src="../logo/miistore2.png" /></a>
			</div>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown user-menu">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-users"></i> <?php echo $name['fullname']; ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="profil.php?id=<?php echo $id;?>"><i class="fa fa-user"></i> Profil</a></li>
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Keluar</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	
	<div id="wrapper">
		<aside id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li><a href="miadmin.php"><i class="fa fa-dashboard"></i> Beranda</a></li>
				<li class="active"><a href="order_confirmation.php"><i class="fa fa-shopping-cart"></i> Pesanan</a></li>
				<li class="sidebar-child"><a href="#"><i class="fa fa-th"></i> Produk Manager <i class="sidebar-fa fa fa-angle-down pull-right"></i></a>
					<ul class="sidebar-second-child">
						<li><a href="brands.php">Produk Brand</a></li>
						<li><a href="categories.php">Produk Kategori</a></li>
						<li><a href="subcategories.php">Produk Subkategori</a></li>
						<li><a href="colors.php">Produk Warna</a></li>
						<li><a href="product.php">Data Produk</a></li>
					</ul>
				</li>
				<li class="sidebar-child"><a href="#"><i class="fa fa-th"></i> Laporan <i class="sidebar-fa fa fa-angle-down pull-right"></i></a>
					<ul class="sidebar-second-child">
						<li><a href="item_report.php">Laporan Data Produk</a></li>
						<li><a href="item_catsubcat_report.php">Laporan Data Produk Berdasarkan Kategori / Subkategori</a></li>
						<li><a href="order_report.php">Laporan Data Pemesanan</a></li>
						<li><a href="order_report_bydate.php">Laporan Data Pemesanan Berdasarkan Tanggal</a></li>
						<li><a href="customer_report.php">Daftar Kontak Pelanggan</a></li>
					</ul>
				</li>
				<li class="sidebar-child"><a href="#"><i class="fa fa-th"></i> Grafik<i class="sidebar-fa fa fa-angle-down pull-right"></i></a>
					<ul class="sidebar-second-child">
						<li><a href="chart_sell_byday.php">Penjualan per Hari</a></li>
						<li><a href="chart_sell_bymonth.php">Penjualan per Bulan</a></li>
						<li><a href="chart_order_byday.php">Pemesanan per Hari</a></li>
						<li><a href="chart_order_bymonth.php">Pemesanan per Bulan</a></li>
					</ul>
				</li>
			</ul>  
		</aside>
		<?php
		include "library.php";
		
		$act = @$_GET['act'];
		
		switch($act){
			default:
			
		?>
		<div id="page-content-wrapper" style="margin-top:50px;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1>Pesanan</h1>
						<div class="clearfix"></div>
						<div class="table-responsive">
							<table id="data" class="table table-bordered results">
								<thead>
									<tr>
										<th width="10">#</th>
										<th>Tanggal</th>
										<th>Kode Pesanan</th>
										<th>Jumlah Sudah Di bayar</th>
										<th>Status Pengiriman</th>
										<th>Print</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>
		<?php
			$sql = "SELECT * FROM orders";
			$query = mysqli_query($conn, $sql);
			$no = 0;
			while($row = mysqli_fetch_assoc($query)){
		?>
									<tr>
										<td width="10" align="center"><?php echo ++$no; ?></td>
										<td align="center"><?php echo fixdate($row['creation_date']); ?></td>
										<td width="15" align="center"><?php echo $row['order_id']; ?></td>
										<td align="center"><?php echo 'Rp '.number_format($row['totals'],0,".","."); ?></td>
										<td align="center"><?php echo $row['order_status']; ?></td>
										<td width="50" align="center">
											<a href="?act=view&id=<?php echo $row['order_id']; ?>" class="mybtn"><i class="fa fa-print"></i></a>
										</td>
										<td width="50" align="center">
											<a href="?act=edit&id=<?php echo $row['order_id']; ?>" class="mybtn"><i class="fa fa-pencil-square-o"></i></a>
										</td>
									</tr>
		<?php } ?>
								</tbody>
							</table>
						</div>
					</div>			
				</div>
			</div>
		</div>	
		<?php
		break;
		case "edit":
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
		<?php
					
					$id = $_GET['id'];

					$query = mysqli_query($conn, "SELECT * FROM orders INNER JOIN members ON members.member_id = orders.customer_id WHERE orders.order_id = '".$id."'");
					$data = mysqli_fetch_array($query);
					
					$error = false;
					$order = "";
					$orderErr = "";
							
					if(isset($_POST['update'])){
								
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							if(empty($_POST['orderstatus'])){
								$error = true;
								$orderErr = "Pilih yang mana";
							}else{
								$order = $_POST['orderstatus'];
							}
						}
								
						if(!$error){
							date_default_timezone_set('Asia/Jakarta');
							$regdate = date('Y-m-d');
							$regtime = date('G:i:s');
							
							mysqli_query($conn,"UPDATE orders SET order_status='".$order."', order_valid_date = '".$regdate."', order_valid_time = '".$regtime."' WHERE order_id='".$id."'");
							header('location: order_confirmation.php');
						}
					}
					
		?>
						<form action="?act=edit&id=<?php echo $_GET['id'];?>" class="form-horizontal" method="POST">
							<legend>Ubah Status Pengiriman</legend>
							<!-- Category Name -->
							<div class="form-group">
								<label class="col-md-2 control-label">Kode Pemesanan : </label>
								<div class="col-md-10">
									<label class="control-label" style="font-size:16px;"><?php echo $data['order_id']; ?></label>
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Pembeli : </label>
								<div class="col-md-10">
									<label class="control-label"><?php echo $data['fullname']; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Bank Asal : </label>
								<div class="col-md-10">
									<label class="control-label"><?php echo $data['cardbank_type']; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Status Pembayaran : </label>
								<div class="col-md-10">
									<label class="control-label"><?php echo $data['payment_status']; ?></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Status Pengiriman : </label>
								<div class="col-md-10">
									<div class="checkboxcss">
										<?php
										if($data['order_status'] == "PENDING"){
											echo '<input type="radio" name="orderstatus" value="PENDING" checked>PENDING ';
											echo '<input type="radio" name="orderstatus" value="SENT">SENT ';
										}elseif($data['order_status'] == "SENT"){
											echo '<input type="radio" name="orderstatus" value="PENDING">PENDING ';
											echo '<input type="radio" name="orderstatus" value="SENT" checked>SENT ';
										}else{
											echo '<input type="radio" name="orderstatus" value="PENDING">PENDING ';
											echo '<input type="radio" name="orderstatus" value="SENT">SENT ';
										}
										?>
									</div>
									<span class="text-danger"><?php echo $orderErr ; ?></span>
								</div>
							</div>
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="update">Update</button>
									<a href="order_confirmation.php"><button type="button" class="btn btn-link">Batal</button></a>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-12" style="margin-top:-6%; margin-bottom: 3%;">
						<div class="table-responsive">
							<table class="table table-bordered results">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode Produk</th>
										<th>Gambar</th>
										<th>Nama Produk</th>
										<th>Warna</th>
										<th>Ukuran</th>
										<th>Jumlah</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$query = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = '".$_GET['id']."'");
								$no = 1;
								while($row = mysqli_fetch_array($query)){
								?>
									<tr>
										<td width="10" align="center"><?php echo $no; ?></td>
										<td width="10" align="center"><?php echo $row['item_code']; ?></td>
										<td align="center"><img src="img/<?php echo $row['bgimg']; ?>" class="img-small"></td>
										<td><?php echo $row['item_name']; ?></td>
										<td align="center"><?php echo $row['color']; ?></td>
										<td align="center"><?php echo $row['size']; ?></td>
										<td align="center"><?php echo $row['qty']; ?></td>
									</tr>
								<?php
									$no++;
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		break;
		case "view";
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-12 text-right">
						<div class="back-right"><a href="order_confirmation.php"><i class="fa fa-arrow-left"></i> KEMBALI</a></div>
						<button class="btn btn-link" onclick="PrintDiv('divToPrint')">Print</button>
					</div>
				</div>
				<div id="divToPrint">
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-lg-12" style="margin-bottom:40px;">
							<div class="col-xs-6">
								<img class="logo-img" src="../logo/miistore1.png" />
							</div>
							<div class="col-xs-6 text-right" style="margin-top: 10px;">
								<address>
								Jl. Raya Condet Jakarta Timur<br/>
								Telepon : 021 23456789<br/>
								Email : info@miistore.com
								</address>
							</div>
							<?php
							$query = "SELECT * FROM orders INNER JOIN members ON members.member_id = orders.customer_id WHERE orders.order_id = '".$_GET['id']."'";
							$result = mysqli_query($conn, $query);
							while($row = mysqli_fetch_array($result)){
							?>
							<div class="col-xs-12 text-center">
								<h3>Faktur Pemesanan</h3>
								<center><h5>No pemesanan : <?php echo $_GET['id']; ?></h5></center>
							</div>
							<hr>
							<div class="row" style="margin-bottom: 10px;">
								<div class="col-xs-6">
									<strong>Kepada Yth:</strong>
									<address>
									<?php 
									echo '
									'.$row['fullname'].'<br/>
									'.$row['address'].'<br/>
									'.$row['city'].'<br/>
									'.$row['state'].'<br/>
									'.$row['zip_code'].'<br/>
									Telp '.$row['phone'].'
									'; 
									?>
									</address>
								</div>
								<div class="col-xs-6 text-right">
									<strong>Tanggal Pemesanan</strong><br/>
									<?php 
									$date = ''.$row['creation_date'].'';
									$date_detail = date('d-m-Y', strtotime($date));
									echo $date_detail.' '.$row['creation_time'];
									?>
								</div>
								<div class="col-xs-6 text-right">
									<strong>Tanggal Pengiriman</strong><br/>
									<?php 
									$sentdate = ''.$row['order_valid_date'].'';
									$sentdate_detail = date('d-m-Y', strtotime($sentdate));
									echo $sentdate_detail.' '.$row['order_valid_time'];
									?>
								</div>
							</div>
							<?php
							}
							?>
							<div class="col-lg-12">
								<div class="table-responsive">
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
										$query = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = '".$_GET['id']."'");
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
													<img src="img/<?php echo $row['bgimg']; ?>" class="img-small">
												</div>
												<div class="table-column-right">
													Kode : <?php echo $row['item_code']; ?><br/>
													Nama : <?php echo $row['item_name']; ?><br/>
													Warna : <?php echo $row['color']; ?><br/>
													Ukuran : <?php echo $row['size']; ?><br/>
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
								<div style="margin-top:3%;"><p>Terima kasih atas pembelian Anda di MiiStore, kami senang bahwa Anda telah memilih berbelanja dengan MiiStore dan kami berharap dapat melayani Anda kembali.</p></div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<?php
		break;
		case "delete":
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$qty = $_GET['qty'];
				$query = "DELETE orders, order_detail FROM orders INNER JOIN order_detail ON order_detail.order_id = orders.order_id WHERE orders.order_id = '$id'";
				mysqli_query($conn,"UPDATE items INNER JOIN order_detail ON order_detail.item_code = items.item_id SET items.stock = items.stock + order_detail.qty WHERE items.item_id = '$qty'");
				
				if(!$res = mysqli_query($conn,$query)){
					exit(mysqli_error($conn));
				}
				header('location: order_confirmation.php');
			}
		?>
		
		<?php
		break;
		}
		
		ob_end_flush();
		?>
	</div>
	
	<footer class="footer-bottom">
		<div class="footer-right">
			&copy; 2019 MiiStore. All Rights Reserved | Design by Victory Webstore
		</div>
		<div class="clearfix"></div>
	</footer>
	
	<!-- JS Offline -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>