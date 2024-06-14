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
?>>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MiiStore | Laporan Data Produk Berdasarkan Kategori dan Subkategori</title>
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
						<li class="active"><a href="item_catsubcat_report.php">Laporan Data Produk Berdasarkan Kategori / Subkategori</a></li>
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
		?>
		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<form class="form-horizontal">
							<legend>Laporan Data Produk Berdasarkan Kategori dan Subkategori</legend>
							<p>Pencarian data produk menurut kategori dan subkategori</p>
							<!-- Tipe Kategori dan Subkategori -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Jenis Kategori dan Subkategori</label>
								<div class="col-md-3">
									<select name="cat_id" id="catid" class="form-control scatid">
										<option value="blank">-- Pilih jenis kategori --</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM categories ORDER BY category ASC");
										while($cat = mysqli_fetch_array($query)){
										?>
											<option value="<?php echo $cat['cat_id']; ?>" <?php if($_POST['cat_id'] == $cat['cat_id']) echo 'selected="selected"'; ?>><?php echo $cat['category']; ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="scat_id" id="subcat" class="form-control scatid" onchange="customselected(this.value);">
										<option value="blank">-- Pilih jenis subkategori --</option>
									</select>
								</div>
								<div class="col-md-3">
									<button class="btn btn-warning" id="resetcatsubcat">Reset</button>
								</div>
							</div>
						</form>
						
						<div class="catsubcat" style="margin-top: -7%; margin-bottom: 10%;">
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
					$perpage = 15;
					$page = isset($_GET['page']) ? $_GET['page'] : "";
					
					if(empty($page)){
						$num = 0;
						$page = 1;
					}else{
						$num = ($page - 1) * $perpage;
					}
					$sql1 = "SELECT * FROM items INNER JOIN colors ON colors.clr_id = items.clr_id INNER JOIN brands ON brands.brd_id = items.brd_id INNER JOIN categories ON 
							  categories.cat_id = items.cat_id INNER JOIN subcategories ON subcategories.scat_id = items.scat_id ORDER BY creation_date ASC LIMIT $num, $perpage";
					$query = mysqli_query($conn, $sql1);
					while($row = mysqli_fetch_array($query)){
						$totalDisc = $row['price']-($row['price'] * $row['discount']/100);
						$total1 = $total1 + $totalDisc;
						$total2 = $total2 + $row['stock'];
				?>
										<tr>
											<td width="10" align="center"><?php echo ++$num; ?></td>
											<td align="center"><?php echo fixdate($row['creation_date']); ?></td>
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
							<?php
							$sql2 = mysqli_query($conn, "SELECT * FROM items INNER JOIN colors ON colors.clr_id = items.clr_id INNER JOIN brands ON brands.brd_id = items.brd_id INNER JOIN categories ON 
							  categories.cat_id = items.cat_id INNER JOIN subcategories ON subcategories.scat_id = items.scat_id");
							$total_record = mysqli_num_rows($sql2);
							$total_page = ceil($total_record / $perpage);
							?>
							<div class="col-lg-12 col-xs-12">
								<nav class="text-center">
									<ul class="pagination" style="margin-bottom: 5%;">
										<?php
										if($page > 1){
											$prev = "<a href='item_catsubcat_report.php?page=1'><span aria-hidden='true'>First</span></a>";
										}else{
											$prev = "<a href=''><span aria-hidden='true'>First</span></a>";
										}
										$number = '';
										for($i=1; $i<=$total_page; $i++){ 
											if($i == $page){
												$number .= "<a href='item_catsubcat_report.php?page=$i'>$i</a>";
											}else{
												$number .= "<a href='item_catsubcat_report.php?page=$i'>$i</a>";
											}
										}
										if($page < $total_page){
											$link = $page + 1;
											$next = "<a href='item_catsubcat_report.php?page=$total_page'><span aria-hidden='true'>Last</span></a>";
										}else{
											$next = "<a href=''><span aria-hidden='true'>Last</span></a>";
										}
										?>
										<li><?php echo $prev; ?></li>
										<li><?php echo $number; ?></li>
										<li><?php echo $next; ?></li>
									</ul>
								</nav>
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
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>