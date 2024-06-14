<?php
require_once("connect.php");

ob_start();
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
	<title>MiiStore | Kategori</title>
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
					<ul class="sidebar-second-child" style="display:block;">
						<li><a href="brands.php">Produk Brand</a></li>
						<li class="active"><a href="categories.php"></i> Produk Kategori</a></li>
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
		
		$act = @$_GET['act'];
		
		switch($act){
			default:
			
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1>Kategori</h1>
						<a href="?act=add" class="btn btn-default"><i class="fa fa-plus"></i> Tambah Baru</a>
						<div class="clearfix"></div>
						
						<div class="table-responsive" style="margin-top:10px;">
							<table id="data" class="table table-bordered results">
								<thead>
									<tr>
										<th width="10">#</th>
										<th>Nama Kategori</th>
										<th>Edit</th>
										<th>Hapus</th>
									</tr>
								</thead>
								<tbody>
		<?php
			$sql = "SELECT * FROM categories";
			$query = mysqli_query($conn, $sql);
			$no = 0;
			while($row = mysqli_fetch_assoc($query)){
		?>
									<tr>
										<td width="10" align="center"><?php echo ++$no; ?></td>
										<td><?php echo $row['category']; ?></td>
										<td width="50" align="center">
											<a href="?act=edit&id=<?php echo $row['cat_id']; ?>" class="mybtn"><i class="fa fa-pencil-square-o"></i></a>
										</td>
										<td width="50" align="center">
											<a href="<?php echo $row['cat_id']; ?>" data-target="#confirm-delete_<?php echo $row['cat_id']; ?>" data-toggle="modal" class="mybtn btn-show"><i class="fa fa-trash-o"></i></a>
											<div class="modal fade" id="confirm-delete_<?php echo $row['cat_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
															<h4 class="modal-tittle">
																<i class="fa fa-trash-o"></i> Konfirmasi (<?php echo $row['cat_id']; ?>)
															</h4>
														</div>
														<div class="modal-body">
															<p>Yakinkah Anda ingin menghapus data ini ?</p>
														</div>
														<div class="modal-footer">
															<a href="?act=delete&id=<?php echo $row['cat_id']; ?>" class="btn btn-danger" id="<?php echo $row['cat_id']; ?>">Ya</a>
															<a href="#" type="button" class="btn btn-default btn-cancel" data-dismiss="modal" aria-hidden="true">Tidak</a>
														</div>
													</div>
												</div>
											</div>	
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
			case 'add':
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
										

		<?php
							$error = false;
							
							$category = "";
							$catErr = "";
							
							if(isset($_POST['save'])){
								$query = mysqli_query($conn,"SELECT * FROM categories WHERE category='".$_POST['cat_name']."'");
								
								if($_SERVER['REQUEST_METHOD'] == "POST"){	
									if(empty($_POST['cat_name'])){
										$error = true;
										$catErr = "Masukkan isi nama kategori";
									}else{
										$category = $_POST['cat_name'];
										if(!preg_match("/^[a-zA-Z ]*$/",$_POST['cat_name'])){
											$error = true;
											$catErr = "Isi nama kategori harus menggunakan huruf dan spasi";
										}
									}
								}
								
								if(!$error){
									if(mysqli_num_rows($query) > 0){
										echo "<div class='alert alert-danger'>Kategori <b>$category</b> sudah masih ada!</div>";
									}else{
										mysqli_query($conn,"INSERT INTO categories VALUES (NULL,'$category')");
										header('location: categories.php');
									}
								}
							}
		?>
						
						<form action="?act=add" class="form-horizontal" method="POST">
							<legend>Tambah Baru</legend>
							<!-- Category Name -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Kategori <i>(required)</i></label>
								<div class="col-md-10">
									<input type="text" name="cat_name" placeholder="Masukkan isi nama kategori" class="form-control" value="<?php echo isset($category) ? $category : ' ';?>">
									<span class="text-danger"><?php echo $catErr ; ?></span>
								</div>
							</div>
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="save">Simpan</button>
									<a href="categories.php"><button type="button" class="btn btn-link">Batal</button></a>
								</div>
							</div>	
						</form>
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

					$query = mysqli_query($conn, "SELECT * FROM categories WHERE cat_id = '".$id."'");
					$data = mysqli_fetch_array($query);
					
					$error = false;
					$category = "";
					$catErr = "";
							
					if(isset($_POST['update'])){
								
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							if(empty($_POST['cat_name'])){
								$error = true;
								$catErr = "Please enter the category name";
							}else{
								$category = mysqli_real_escape_string($conn,$_POST['cat_name']);
								if(!preg_match("/^[a-zA-Z ]*$/",$_POST['cat_name'])){
									$error = true;
									$catErr = "Name must contain only alphabets and space";
								}
							}
						}
								
						if(!$error){
							mysqli_query($conn,"UPDATE categories SET category='$category' WHERE cat_id='".$id."'");
							header('location: categories.php');
						}
					}
					
		?>
						<form action="?act=edit&id=<?php echo $_GET['id'];?>" class="form-horizontal" method="POST">
							<legend>Edit Category</legend>
							<!-- Category Name -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Kategori <i>(required)</i></label>
								<div class="col-md-10">
									<input type="text" name="cat_name" value="<?php echo isset($_POST['cat_name']) ? $_POST['cat_name'] : $data['category']; ?>" class="form-control">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
									<span class="text-danger"><?php echo $catErr ; ?></span>
								</div>
							</div>
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="update">Ubah</button>
									<a href="categories.php"><button type="button" class="btn btn-link">Batal</button></a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		break;
		case "delete":
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$query = "DELETE FROM categories WHERE cat_id = '$id'";
				if(!$res = mysqli_query($conn,$query)){
					exit(mysqli_error());
				}
				header('location: categories.php');
			}
		?>
		
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
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>

<?php
ob_end_flush();
?>