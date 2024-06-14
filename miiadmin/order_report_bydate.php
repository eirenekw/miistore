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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MiiStore | Laporan Pemesanan Menurut Tanggal</title>
	<meta name="keywords" content="men, women, clothing, home" />
	<meta name="author" content="Victory Webstore"/>
	
	<!-- mobile specific -->
	<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="../logo/miistore-favicon.png" />
	
	<!-- CSS Offline -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/miiadmin.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
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
						<li><a href="#"><i class="fa fa-user"></i> Profil</a></li>
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
				<li><a href="order_confirmation.php"><i class="fa fa-shopping-cart"></i> Pesanan</a></li>
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
					<ul class="sidebar-second-child" style="display:block;">
						<li><a href="item_report.php">Laporan Data Produk</a></li>
						<li><a href="item_catsubcat_report.php">Laporan Data Produk Berdasarkan Kategori / Subkategori</a></li>
						<li><a href="order_report.php">Laporan Data Pemesanan</a></li>
						<li class="active"><a href="order_report_bydate.php">Laporan Data Pemesanan Berdasarkan Tanggal</a></li>
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
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<form action="order_report_bydate.php" class="form-horizontal" method="POST">
							<legend>Laporan Pemesanan Berdasarkan Tanggal</legend>
							<p>Pencarian data menurut tanggal</p>
							<!-- Tanggal Awal -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Tanggal Awal</label>
								<div class="col-md-2">
									<div class="input-group date" id="startdate">
										<input type="text" name="date1" class="form-control date1" value="<?php echo isset($_POST['date1']) ? $_POST['date1'] : ' ';?>">
										<div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
									</div>
								</div>
							</div>
							<!-- Tanggal Akhir -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Tanggal Akhir</label>
								<div class="col-md-2">
									<div class="input-group date" id="enddate">
										<input type="text" name="date2" class="form-control date2" value="<?php echo isset($_POST['date2']) ? $_POST['date2'] : ' ';?>">
										<div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
									</div>
								</div>
							</div>
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<input type="submit" class="btn btn-warning" name="find" value="Cari">
									<button class="btn btn-warning" id="reset-date">Reset</button>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
						<?php
						include "library.php";
						
						if(isset($_POST['find'])){
							$start = $_POST['date1'];
							$start_detail = date('Y-m-d', strtotime($start));
							
							$end = $_POST['date2'];
							$end_detail = date('Y-m-d', strtotime($end));
							
							if(empty(trim($_POST['date1'])) OR empty(trim($_POST['date2']))){
								echo '<span class="text-danger">Masukan isi tanggal. Silakan di isi.</span>';
							}else{
						?>
						<div class="orderbydate">
							<div class="col-lg-12" style="margin-top: -5%;">
								<button type="button" class="btn btn-link" onclick="window.open('pdf/date_order_report_bypdf.php?tgl1=<?php echo $_POST['date1']; ?>&tgl2=<?php echo $_POST['date2']; ?>');"> Lihat PDF</button>
							</div>
							<div id="divToPrint">
								<div class="table-responsive">
									<table class="table table-bordered" style="margin-bottom: 3%;">
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>Kode Pemesan</th>
												<th>Nama Pelanggan</th>
												<th>Nama Produk</th>
												<th>Qty</th>
												<th>Harga</th>
												<th>Diskon</th>
												<th>Harga Diskon</th>
												<th>Subtotal</th>
											</tr>
										</thead>
							<?php
							$query = '
										SELECT orders.*, members.fullname, order_detail.*,
										order_detail.price-(order_detail.price*order_detail.disc/100) AS hargadiskon 
										FROM orders INNER JOIN order_detail ON order_detail.order_id = orders.order_id INNER JOIN members ON members.member_id = orders.customer_id
										WHERE orders.creation_date BETWEEN "'.$start_detail.'" AND "'.$end_detail.'"
										';
							$result = mysqli_query($conn, $query);
							if(mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_assoc($result)){
									$subtotal = $row['qty'] * $row['hargadiskon'];
									$total = $total + $subtotal;
									$totalqty = $totalqty + $row['qty'];
							?>
										<tbody>
											<tr>
												<td align="center"><?php echo fixdate($row['creation_date']); ?></td>
												<td align="center"><?php echo $row['order_id']; ?></td>
												<td align="center"><?php echo $row['fullname']; ?></td>
												<td align="center"><?php echo $row['item_name']; ?> (<?php echo $row['item_code']; ?>)</td>
												<td align="center"><?php echo $row['qty']; ?></td>
												<td align="center"><?php echo 'Rp '.number_format($row['price'],0,".","."); ?></td>
												<td align="center"><?php echo $row['disc']; ?>%</td>
												<td align="center"><?php echo 'Rp '.number_format($row['hargadiskon'],0,".","."); ?></td>
												<td align="center"><?php echo 'Rp '.number_format($subtotal,0,".","."); ?></td>
											</tr>
								<?php
								}
								?>
											<tr>
												<td colspan="8" align="right">Total</td>
												<td align="center"><?php echo 'Rp '.number_format($total,0,".","."); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-lg-12" style="margin-bottom: 10%;">
									<p>Jumlah/qty : <?php echo $totalqty; ?></p>
								</div>
							</div>
						</div>
						<?php
								}else{
									echo "<div class='alert alert-danger'>Maaf data ini tidak di temukan!</div>";
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<footer class="footer-bottom">
		<div class="footer-right">
			&copy; 2019 MiiStore. All Rights Reserved | Design by Eirene KW
		</div>
		<div class="clearfix"></div>
	</footer>
	
	<!-- JS Offline -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>