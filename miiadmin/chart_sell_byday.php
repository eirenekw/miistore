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
	<title>MiiStore | Statistika Penjualan per Hari</title>
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
	
	<!-- JS Offline -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/chart.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js//html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
	<style type="text/css" media="print">
	@page { size: landscape;}
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
					<ul class="sidebar-second-child">
						<li><a href="item_report.php">Laporan Data Produk</a></li>
						<li><a href="item_catsubcat_report.php">Laporan Data Produk Berdasarkan Kategori / Subkategori</a></li>
						<li><a href="order_report.php">Laporan Data Pemesanan</a></li>
						<li><a href="order_report_bydate.php">Laporan Data Pemesanan Berdasarkan Tanggal</a></li>
						<li><a href="customer_report.php">Daftar Kontak Pelanggan</a></li>
					</ul>
				</li>
				<li class="sidebar-child"><a href="#"><i class="fa fa-th"></i> Grafik<i class="sidebar-fa fa fa-angle-down pull-right"></i></a>
					<ul class="sidebar-second-child" style="display:block;">
						<li class="active"><a href="chart_sell_byday.php">Penjualan per Hari</a></li>
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
					<div class="col-lg-12" style="margin-bottom: 8%;">
						<div class="title-chartjs">
							<?php
							$months = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
										   
							echo '<h4> bulan '.$months[date("n")].' '.date("Y").'</h4>';
							?>
						</div>
						<div class="chartjs">
							<?php
							include "connect.php";
							
							$query = "SELECT i1.day, COALESCE(i2.amount,0) AS totalamount
										  FROM
												(SELECT 1 AS DAY UNION ALL
												 SELECT 2 UNION ALL
												 SELECT 3 UNION ALL
												 SELECT 4 UNION ALL
												 SELECT 5 UNION ALL
												 SELECT 6 UNION ALL
												 SELECT 7 UNION ALL
												 SELECT 8 UNION ALL
												 SELECT 9 UNION ALL
												 SELECT 10 UNION ALL
												 SELECT 11 UNION ALL
												 SELECT 12 UNION ALL
												 SELECT 13 UNION ALL
												 SELECT 14 UNION ALL
												 SELECT 15 UNION ALL
												 SELECT 16 UNION ALL
												 SELECT 17 UNION ALL
												 SELECT 18 UNION ALL
												 SELECT 19 UNION ALL
												 SELECT 20 UNION ALL
												 SELECT 21 UNION ALL
												 SELECT 22 UNION ALL
												 SELECT 23 UNION ALL
												 SELECT 24 UNION ALL
												 SELECT 25 UNION ALL
												 SELECT 26 UNION ALL
												 SELECT 27 UNION ALL
												 SELECT 28 UNION ALL
												 SELECT 29 UNION ALL
												 SELECT 30 UNION ALL
												 SELECT 31
											   ) i1
										  LEFT JOIN (SELECT DATE_FORMAT(creation_date,'%d') AS day, 
										  SUM(price -(price * discount / 100)) AS amount 
										  FROM items 
										  WHERE MONTH(creation_date) = MONTH(CURRENT_DATE)
										  GROUP BY DATE_FORMAT(creation_date,'%d')) i2 ON i2.day = i1.day 
										  GROUP BY i1.day DESC";
										  
							$result = mysqli_query($conn, $query);
							
							$alldaysarr = array();
							$totalamountarr = array();
							
							while($row = mysqli_fetch_assoc($result)){
								$alldaysarr[] = $row['day'];
								$totalamountarr[] = $row['totalamount'];
									
								$alldays = array_reverse($alldaysarr);
								$totalamount = array_reverse($totalamountarr);
									
								$alldays = implode('","',$alldays);
								$totalamount = implode(", ",$totalamount);
							}
							?>
							<canvas id="chart"></canvas>
							<script>
								$(document).ready(function() {
									var ctx = document.getElementById("chart").getContext('2d');
									var myChart = new Chart(ctx, {
										type: 'line',
										data: {
											labels: [<?php echo '"'.$alldays.'"';?>],
											datasets: [
												{
													label: "Total Rp",
													type: "line",
													data: [<?php echo $totalamount; ?>],
													borderColor: "#008080",
													borderWidth: 1.5,
													pointBorderColor: "rgba(76, 162, 205, 0.85)",
													pointHoverBorderColor: "#008080",
													pointHoverBorderWidth: 2,
													pointBackgroundColor: "#fff",
													pointHoverBackgroundColor: "#fff",
													pointRadius: 2,
													pointHitRadius: 10,
													fill: false
												}
											]
										},
										options: {
											title: {
												display: true,
												text: 'Statistika Total Penjualan per Hari'
											},
											legend: { display: false },
											scales: {
												yAxes: [
													{
														display: true,
														ticks: 
															{
																suggestedMin: 0,
																beginAtZero: true
															}
													}
												]
											}
										}
									});
								});
							</script>
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
	
</body>
</html>