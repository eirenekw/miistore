<?php
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
	<title>MiiStore | Dashboard</title>
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
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
	
</head>
<body>
	<?php
	$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '".$id."'");
	$data = mysqli_fetch_array($query);
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
						<i class="fa fa-users"></i> <?php echo $data['fullname']; ?> <span class="caret"></span>
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
				<li class="active"><a href="miadmin.php"><i class="fa fa-dashboard"></i> Beranda</a></li>
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
		include "connect.php";
		$sql = "SELECT (
					SELECT counter_visit FROM counter WHERE DATE(counter_date) = DATE(CURRENT_DATE)
				) AS today,
					(SELECT counter_visit FROM counter WHERE DATE(counter_date) = DATE(CURRENT_DATE - INTERVAL 1 DAY)
				) AS yesterday,
					(SELECT SUM(counter_visit) FROM counter WHERE WEEKOFYEAR(counter_date) = WEEKOFYEAR(CURRENT_DATE - INTERVAL 1 WEEK)
				) AS last_week,
					(SELECT SUM(counter_visit) FROM counter WHERE WEEKOFYEAR(counter_date) = WEEKOFYEAR(CURRENT_DATE)
				) AS this_week,
					(SELECT SUM(counter_visit) FROM counter WHERE MONTH(counter_date) = MONTH(CURRENT_DATE) AND YEAR(counter_date) = YEAR(CURRENT_DATE)
				) AS this_month,
					(SELECT SUM(counter_visit) FROM counter WHERE YEAR(counter_date) = YEAR(CURRENT_DATE)
				) AS this_year";
		$query = mysqli_query($conn, $sql);
		$visit = mysqli_fetch_array($query);
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1>Dashboard</h1>
						<div class="clearfix"></div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Hari Ini
							<div class="counter_hit">
								<?php 
								if(!empty($visit['today'])){
									echo $visit['today'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Kemarin</span>
							<div class="counter_hit">
								<?php 
								if(!empty($visit['yesterday'])){
									echo $visit['yesterday'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Minggu Lalu</span>
							<div class="counter_hit">
								<?php 
								if(!empty($visit['last_week'])){
									echo $visit['last_week'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Minggu Ini</span>
							<div class="counter_hit">
								<?php 
								if(!empty($visit['this_week'])){
									echo $visit['this_week'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Bulan Ini</span>
							<div class="counter_hit">
								<?php 
								if(!empty($visit['this_month'])){
									echo $visit['this_month'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
						<div class="col-lg-2 col-xs-6 counters">
							<i class="fa fa-user"></i> Total Pengunjung Tahun Ini</span>
							<div class="counter_hit">
								<?php 
								if(!empty($visit['this_year'])){
									echo $visit['this_year'];
								} else {
									echo '0';
								}
								?>
							</div>
						</div>
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
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>
