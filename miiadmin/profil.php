<?php
require_once("connect.php");

session_start();
ob_start();

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
	<title>MiiStore | Profil Saya</title>
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
	$ids = $_GET['id'];
	$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '".$ids."'");
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
						<li><a href="#"><i class="fa fa-user"></i> Profil</a></li>
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Keluar</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	
	<div id="wrapper">
		<nav id="sidebar-wrapper">
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
					<ul class="sidebar-second-child">
						<li><a href="chart_sell_byday.php">Penjualan per Hari</a></li>
						<li><a href="chart_sell_bymonth.php">Penjualan per Bulan</a></li>
						<li><a href="chart_order_byday.php">Pemesanan per Hari</a></li>
						<li><a href="chart_order_bymonth.php">Pemesanan per Bulan</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<?php 
		include "connect.php";
		
		$act = @$_GET['act'];
		
		switch($act){
			default:
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<?php
							
						$error = false;
						$nama = $user = "";
						$namaErr = $userErr = "";
							
						if(isset($_POST['update'])){
								
							if($_SERVER['REQUEST_METHOD'] == "POST"){
								if(empty($_POST['fullname'])){
									$error = true;
									$namaErr = "Masukkan isi nama lengkap Anda";
								}else{
									$nama = mysqli_real_escape_string($conn,$_POST['fullname']);
									if(!preg_match("/^[a-zA-Z .\-']*$/",$_POST['fullname'])){
										$error = true;
										$namaErr = "Isi nama lengkap harus menggunakan huruf, karakter dan spasi";
									}
								}
											
								if(empty($_POST['user'])){
									$error = true;
									$userErr = "Please enter an Username";
								}else{
									$user = mysqli_real_escape_string($conn,$_POST['user']);
									if(!preg_match("/^[a-z0-9]*$/",$_POST['user'])){
										$error = true;
										$userErr = "Isi nama pengguna harus menggunakan huruf kecil dan angka";
									}
								}
							}
										
							if(!$error){
								mysqli_query($conn,"UPDATE users SET fullname='$nama',user='$user' WHERE user_id='".$id."'");
								header('location: miadmin.php');
							}
						}
						?>
						<form action="profil.php?id=<?php echo $_GET['id'];?>" class="form-horizontal" method="POST">
							<legend>Profil</legend>
							<!-- Full Name -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Lengkap Anda <i>(required)</i></label>
								<div class="col-md-10">
									<input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : $data['fullname']; ?>" class="form-control">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
									<span class="text-danger"><?php echo $namaErr ; ?></span>
								</div>
							</div>
							<!-- Username -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Pengguna <i>(required)</i></label>
								<div class="col-md-10">
									<input type="text" name="user" value="<?php echo isset($_POST['user']) ? $_POST['user'] : $data['user']; ?>" class="form-control">
									<span class="text-danger"><?php echo $userErr; ?></span>
								</div>
							</div>
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="update">Ubah Profil</button>
									<a href="miadmin.php"><button type="button" class="btn btn-link">Batal</button></a>
								</div>
							</div>
						</form>
						<p class="text-center">Apakah Anda yakin menghapus akun ini? <a href="?act=delete">Hapus Akun Anda</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php
			break;
			case 'delete':
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1>Hapus Akun Anda</h1>
						<b>Yakin ingin menonaktifkan akun Anda?</b><br/>
						<p>Jika akun Anda dinonaktifkan, profil Anda akan dihapus selamanya. <br/>
						<form action="?act=delete" method="POST" style="margin-bottom: 5%;">
							<input type="submit" class="btn btn-warning" name="deactivated" value="Tutup Akun"/>
							<a href="miadmin.php"><button type="button" class="btn btn-link">Tidak</button></a>
						</form>
						<?php
						if(isset($_POST['deactivated'])){
							$query = "DELETE FROM users WHERE user_id = '".$id."'";
							if(!$res = mysqli_query($conn,$query)){
								exit(mysqli_error());
							}
							setcookie('user_id','', time() - 3600);
							session_destroy();

							echo "<meta http-equiv='refresh' content='0; url=index.php'>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		break;
		}
		?>
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
<?php ob_end_flush(); ?>