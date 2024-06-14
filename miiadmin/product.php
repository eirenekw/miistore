<?php
error_reporting(E_ALL ^ E_NOTICE);
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
	<title>MiiStore | Data Produk </title>
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
						<li><a href="categories.php">Produk Kategori</a></li>
						<li><a href="subcategories.php">Product Subkategori</a></li>
						<li><a href="colors.php">Produk Warna</a></li>
						<li class="active"><a href="product.php">Data Produk</a></li>
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
		include "library.php";
		
		$act = @$_GET['act'];
		
		switch($act){
			default:
			
		?>
		<div id="page-content-wrapper" style="margin-top:50px;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1>Data Produk</h1>
						<a href="?act=add" class="btn btn-default"><i class="fa fa-plus"></i> Tambah Baru</a>
						<div class="clearfix"></div>
						
						<div class="table-responsive" style="margin-top:10px;">
							<table id="data" class="table table-bordered results" style="margin-bottom: 5%;">
								<thead>
									<tr>
										<th width="10">#</th>
										<th>Kode Produk</th>
										<th>Gambar</th>
										<th>Nama Produk</th>
										<th>Harga</th>
										<th>Diskon</th>
										<th>Total</th>
										<th>Status</th>
										<th>Edit</th>
										<th>Hapus</th>
									</tr>
								</thead>
								<tbody>
		<?php
			$sql = "SELECT * FROM items INNER JOIN categories ON categories.cat_id = items.cat_id";
			$query = mysqli_query($conn, $sql);
			$no = 0;
			while($row = mysqli_fetch_assoc($query)){
				
		?>
									<tr>
										<td width="10" align="center"><?php echo ++$no; ?></td>
										<td align="center"><?php echo $row['item_id']; ?></td>
										<td align="center"><img src="img/<?php echo $row['bgimg']; ?>" class="img-small"/></td>
										<td><?php echo $row['item_name']; ?></td>
										<td align="right"><?php echo 'Rp '.number_format($row['price'],0,".","."); ?></td>
										<td align="center"><?php echo $row['discount']; ?>%</td>
										<?php $totalDisc = $row['price']-($row['price']*$row['discount']/100); ?>
										<td align="right"><?php echo 'Rp '.number_format($totalDisc,0,".","."); ?></td>
										<td align="center"><?php echo $row['available']; ?></td>
										<td width="50" align="center">
											<a href="?act=edit&id=<?php echo $row['item_id']; ?>" class="mybtn"><i class="fa fa-pencil-square-o"></i></a>
										</td>
										<td width="50" align="center">
											<a href="<?php echo $row['item_id']; ?>" data-target="#confirm-delete_<?php echo $row['item_id']; ?>" data-toggle="modal" class="mybtn btn-show"><i class="fa fa-trash-o"></i></a>
											<div class="modal fade" id="confirm-delete_<?php echo $row['item_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
															<h4 class="modal-tittle">
																<i class="fa fa-trash-o"></i> Konfirmasi (<?php echo $row['item_id']; ?>)
															</h4>
														</div>
														<div class="modal-body">
															<p>Yakinkah Anda ingin menghapus data ini?</p>
														</div>
														<div class="modal-footer">
															<a href="?act=delete&id=<?php echo $row['item_id']; ?>" class="btn btn-danger" id="<?php echo $row['item_id']; ?>">Ya</a>
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
							
							$item = $cat = $scat = $brd = $bgImg = $image = $size = $clr = $detail = $matcar = $price = $disc = $stock = $available = "";
							$itemErr = $catErr = $scatErr = $brdErr = $bgImgErr = $sizeErr = $clrErr = $detailErr = $matcarErr = $priceErr = $discErr = $stockErr = $availableErr = "";
							$A = ""; $B = "";
							
							$cat = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
							
							if(isset($_POST['save'])){
								
								$query = mysqli_query($conn,"SELECT * FROM items WHERE item_name='".$_POST['item']."'");
								
								$bgImg = $_FILES['bg-img']['name'];
								
								if($_SERVER['REQUEST_METHOD'] == "POST"){
									if(empty($_POST['item'])){
										$error = true;
										$itemErr = "Isikan nama item";
									}else{
										$item = $_POST['item'];
										if(!preg_match("/^[a-zA-Z0-9 .\-&]+$/i",$_POST['item'])){
											$error = true;
											$itemErr = "Nama item harus menggunakan huruf, karakter dan spasi";
										}
									}
									
									if(trim($_POST['cat_id']=="blank")){
										$error = true;
										$catErr = "Pilih salah satu jenis kategori";
									}else{
										$cat = $_POST['cat_id'];
									}
									
									if(trim($_POST['scat_id']=="blank")){
										$error = true;
										$scatErr = "Pilih salah satu jenis subkategori";
									}else{
										$scat = $_POST['scat_id'];
									}
									
									if(trim($_POST['brand']=="blank")){
										$error = true;
										$brdErr = "Pilih salah satu tipe brand";
									}else{
										$brd = $_POST['brand'];
									}
									
									if($_FILES['bg-img']['error'] != 0){
										$error = true;
										$bgImgErr = "Pilih gambar";
									}
									
									if(empty($_POST['size'])){
										$error = true;
										$sizeErr = "Harus di centangkan";
									}else{
										$size = $_POST['size'];
									}
									
									if(empty($_POST['color'])){
										$error = true;
										$clrErr = "Harus di centangkan";
									}else{
										$clr = $_POST['color'];
									}
									
									if(empty($_POST['detail'])){
										$error = true;
										$detailErr = "Masukkan isi detail";
									}else{
										$detail = $_POST['detail'];
										if(!preg_match("/^[a-zA-Z0-9 .,\-&]+$/i",$_POST['detail'])){
											$error = true;
											$detailErr = "Detail harus menggunakan huruf, karakter dan spasi";
										}
									}
									
									if(empty($_POST['matcar'])){
										$error = true;
										$matcarErr = "Masukkan isi bahan";
									}else{
										$matcar = $_POST['matcar'];
									}
									
									if(empty($_POST['price'])){
										$error = true;
										$priceErr = "Masukkan isi nominal harga";
									}else{
										$price = $_POST['price'];
										if(!is_numeric($price)){
											$error = true;
											$priceErr = "Isi harga menggunakan angka";
										}
									}
									
									if($_POST['disc'] == "" && !empty($POST['disc'])){
										$error = true;
										$discErr = "Masukkan isi diskon";
									}else{
										$disc = $_POST['disc'];
										if(!preg_match("/^[0-9]+$/i",$_POST['disc'])){
											$error = true;
											$discErr = "Isi diskon menggunakan angka";
										}
									}
									
									if(empty($_POST['stock'])){
										$error = true;
										$stockErr = "Masukkan isi stok";
									}else{
										$stock = $_POST['stock'];
										if(!is_numeric($stock)){
											$error = true;
											$stockErr = "Isi stok menggunakan angka";
										}
									}
									
									if(empty($_POST['available'])){
										$error = true;
										$availableErr = "Pilih mana yang aktif";
									}else{
										$available = $_POST['available'];
										if($available == "Ada"){
											$in = "checked";
										}elseif($available == "Habis"){
											$out = "checked";
										}
									}
									
								}
								
								if(!$error){
									$itemid = $_POST['item_id'];
									$size = implode(',', $_POST['size']);
									$clr = implode(',',$_POST['color']);
									$bgImgNew = date("md").$bgImg;
									
									if(mysqli_num_rows($query) > 0){
										echo "<div class='alert alert-danger'>Item <b>$item</b> sudah masih ada!</div>";
									}else{
										if(strlen($bgImg)>0){
											if(is_uploaded_file($_FILES['bg-img']['tmp_name'])){
												move_uploaded_file($_FILES['bg-img']['tmp_name'],"img/".$bgImgNew);
											}
										}
										
										foreach($_FILES['image']['error'] as $key => $error){
											if($error == UPLOAD_ERR_OK){
											$image = $_FILES['image']['name'][$key];
											$tmp = $_FILES['image']['tmp_name'][$key];
											
												if(is_uploaded_file($tmp)){
													move_uploaded_file($tmp,"img/".$image);
												}
											}
										}
										
										date_default_timezone_set('Asia/Jakarta');
										$regdate = date('Y-m-d');
										$filename = implode(',',$_FILES['image']['name']);
										
										$qry = "INSERT INTO items VALUES ('$itemid','$item','$cat','$scat','$brd','$size','$clr','$bgImgNew','$filename','$detail','$matcar','$price','$disc','$stock','$available','$regdate')";
																		
										mysqli_query($conn, $qry);
										header('location: product.php');
									}
								}
							}
							
		?>
						
						<form action="?act=add" class="form-horizontal" method="POST" enctype="multipart/form-data">
							<legend>Tambah Baru</legend>
							<!-- Kode Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Kode Produk</label>
								<div class="col-md-10">
									<input type="text" name="item_id" class="form-control" value="<?php echo autoNumber('item_id','items'); ?>">
								</div>
							</div>
							
							<!-- Nama Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Produk</label>
								<div class="col-md-10">
									<input type="text" name="item" class="form-control" placeholder="Masukkan isi nama barang" value="<?php echo isset($item) ? $item : ' ';?>">
									<span class="text-danger"><?php echo $itemErr ; ?></span>
								</div>
							</div>
							
							<!-- Tipe Kategori dan Subkategori -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Tipe Kategori dan Subkategori</label>
								<div class="col-md-3">
									<select name="cat_id" id="catid" class="form-control">
										<option value="blank">-- Pilih jenis kategori --</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM categories ORDER BY category ASC");
										while($catid = mysqli_fetch_array($query)){
										?>
											<option <?php if($cat == $catid['cat_id']) echo 'selected' ; ?> value="<?php echo $catid['cat_id']; ?>"><?php echo $catid['category']; ?></option>
										<?php
										}
										?>
									</select>
									<span class="text-danger"><?php echo $catErr ; ?></span>
								</div>
								<div class="col-md-3">
									<select name="scat_id" id="subcat" class="form-control">
										<option value="blank">-- Pilih jenis subkategori --</option>
									</select>
									<span class="text-danger"><?php echo $scatErr ; ?></span>
								</div>
							</div>
							
							<!-- Pilihan Brand -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Brand</label>
								<div class="col-md-10">
									<select name="brand" class="form-control">
										<option value="blank">-- Pilih tipe brand --</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM brands ORDER BY brand ASC");
										while($brd = mysqli_fetch_array($query)){
										?>
											<option value="<?php echo $brd['brd_id']; ?>" <?php if(isset($_POST['brand']) && ($_POST['brand'] == $brd['brd_id'])) echo "selected"; ?>><?php echo $brd['brand']; ?></option>
										<?php
										}
										?>
									</select>
									<span class="text-danger"><?php echo $brdErr ; ?></span>
								</div>
							</div>
							
							<!-- Produk Gambar Single -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Gambar Single</label>
								<div class="col-md-10">
									<div id="image-preview-div"></div>
									<input type="file" name="bg-img" id="imgjs">
									<span class="text-danger"><?php echo $bgImgErr ; ?></span>
									<div id="message"></div>
								</div>
							</div>
							
							<!-- Produk Gambar Multiple -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Gambar Produk</label>
								<div class="col-md-10">
									<div id="preview"></div>
									<input type="file" name="image[]" id="image" multiple><button id="btnDelete" style="display:none;">Delete</button>
									<div id="message"></div>
								</div>
							</div>
							
							<!-- Size -->
							<div class="form-group">
								<label class="col-md-2 control-label">Size</label>
								<div class="col-md-10">
									<?php
									$checkbox_elements = array("S" => array ('allsize' => 'Small'), "M" => array('allsize' => 'Medium'), "L" => array('allsize' => 'Large'), "XL" => array('allsize' => 'Xtra Large'), "XXL" => array('allsize' => 'Xtra-xtra Large'), 
														"21" => array('allsize' => '21'), "22" => array('allsize' => '22'), "23" => array('allsize' => '23'), "24" => array('allsize' => '24'), "25" => array('allsize' => '25'), "26" => array('allsize' => '26'), "27" => array('allsize' => '27'), "28" => array('allsize' => '28'), "29" => array('allsize' => '29'), "30" => array('allsize' => '30'), 
														"31" => array('allsize' => '31'), "32" => array('allsize' => '32'), "33" => array('allsize' => '33'), "34" => array('allsize' => '34'), "35" => array('allsize' => '35'), "36" => array('allsize' => '36'), "37" => array('allsize' => '37'), "38" => array('allsize' => '38'), "39" => array('allsize' => '39'), "40" => array('allsize' => '40'), 
														"41" => array('allsize' => '41'), "42" => array('allsize' => '42'), "43" => array('allsize' => '43'), "44" => array('allsize' => '44'), "45" => array('allsize' => '45'), "46" => array('allsize' => '46'), "47" => array('allsize' => '47'), "48" => array('allsize' => '48'), "49" => array('allsize' => '49'),"50" => array('allsize' => '50'), 
														"51" => array('allsize' => '51'), "52" => array('allsize' => '52'), "0-1Y" => array ('allsize' => '0-1Y'), "2-3Y" => array ('allsize' => '2-3Y'), "4-5Y" => array ('allsize' => '4-5Y'), "6-7Y" => array('allsize' => '6-7Y'), "8-9Y" => array('allsize' => '8-9Y'), "10-11Y" => array('allsize' => '10-11Y'), 
														"12-13Y" => array('allsize' => '12-13Y'), "14-15Y" => array('allsize' => '14-15Y'), "2Y" => array('allsize' => '2Y'), "4Y" => array('allsize' => '4Y'), "6Y" => array('allsize' => '6Y'), "8Y" => array('allsize' => '8Y'), "10Y" => array('allsize' => '10Y'), "12Y" => array('allsize' => '12Y'), "14Y" => array('allsize' => '14Y'), "16Y" => array('allsize' => '16Y'));
									foreach($checkbox_elements as $key => $value){
										echo '<div class="checkboxcss"><input type="checkbox" name="size['.$key.']" id="size_'.$key.'" value="'.$key.'" '.((!empty($size[$key])) ? 'checked' : ' ').'>'.$value['allsize'].'</div>';
									}
									?>
									<br/>
									<span class="text-danger"><?php echo $sizeErr ; ?></span>
								</div>
							</div>
							
							<!-- Color -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Warna</label>
								<div class="col-md-10">
									<?php
									$query = mysqli_query($conn, "SELECT * FROM colors");
									while($clr = mysqli_fetch_array($query)){
										$checkbox_elements = array($clr['clr_id'] => array('allcolor' => $clr['color']));
										foreach($checkbox_elements as $key => $value){
											echo '<div class="checkboxcss"><input type="checkbox" name="color['.$key.']" id="color_'.$key.'" value="'.$key.'" '.((!empty($_POST['color'][$key])) ? 'checked' : ' ').'><span class="clrcode" style="background-color:'.$clr['color_cd'].'"></span>'.$value['allcolor'].'</div>';
										}
									}
									?>
									<br/>
									<span class="text-danger"><?php echo $clrErr ; ?></span>
								</div>
							</div>
							
							<!-- Detail Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Detail Produk</label>
								<div class="col-md-10">
									<textarea name="detail" rows="6" class="form-control"><?php echo isset($detail) ? $detail : ' ';?></textarea>
									<span class="text-danger"><?php echo $detailErr ; ?></span>
								</div>
							</div>
							
							<!-- Bahan dan Perawatan -->
							<div class="form-group">
								<label class="col-md-2 control-label">Bahan dan Perawatan</label>
								<div class="col-md-10">
									<textarea name="matcar" rows="4" class="form-control"><?php echo isset($matcar) ? $matcar : ' ';?></textarea>
									<span class="text-danger"><?php echo $matcarErr ; ?></span>
								</div>
							</div>
							
							<!-- Harga Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Harga Produk</label>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-addon"><span>Rp</span></div><input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo isset($price) ? $price : ' ';?>">
									</div>
									<span class="text-danger"><?php echo $priceErr ; ?></span>
								</div>
							</div>
							
							<!-- Diskon-->
							<div class="form-group">
								<label class="col-md-2 control-label">Diskon</label>
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" name="disc" class="form-control" placeholder="Discount" value="0"><span class="input-group-addon" value="<?php echo isset($disc) ? $disc : ' ';?>"><i>%</i></span>
									</div>
									<span class="text-danger"><?php echo $discErr ; ?></span>
								</div>
							</div>
							
							<!-- Stok Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Stok Produk</label>
								<div class="col-md-2">
									<input type="text" name="stock" class="form-control" placeholder="Stock" value="<?php echo isset($stock) ? $stock : ' ';?>">
									<span class="text-danger"><?php echo $stockErr ; ?></span>
								</div>
							</div>
							
							<!-- Status Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Status Produk</label>
								<div class="col-md-10">
									<div class="checkboxcss">
										<input type="radio" name="available" value="Ada" <?php echo $in; ?>>Ada
										<input type="radio" name="available" value="Habis" <?php echo $out; ?>>Habis
									</div>
									<span class="text-danger"><?php echo $availableErr ; ?></span>
								</div>
							</div>
							
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="save">Simpan</button>
									<a href="product.php"><button type="button" class="btn btn-link">Batal</button></a>
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

					$query = mysqli_query($conn, "SELECT * FROM items WHERE item_id = '".$id."'");
					$data = mysqli_fetch_array($query);
					
					$error = false;
					
					$item = $cat = $scat = $brd = $size = $clr = $desc = $price = $detail = $matcar = $stock = $available = "";
					$itemErr = $catErr = $scatErr = $brdErr = $sizeErr = $clrErr = $detailErr = $matcarErr = $priceErr = $stockErr = $availableErr = "";
					$A = ""; $B = "";
							
					if(isset($_POST['update'])){
						
						$disc = $_POST['disc'];
						$available = $_POST['available'];
								
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							
							if(empty($_POST['item'])){
								$error = true;
								$itemErr = "Masukkan isi nama produk";
							}else{
								$item = $_POST['item'];
								if(!preg_match("/^[a-zA-Z0-9 .\-&]+$/i",$_POST['item'])){
									$error = true;
									$itemErr = "Nama item harus menggunakan huruf, karakter dan spasi";
								}
							}
									
							if(trim($_POST['cat_id']=="blank")){
								$error = true;
								$catErr = "Pilih salah satu jenis kategori";
							}else{
								$cat = $_POST['cat_id'];
							}
									
							if(trim($_POST['scat_id']=="blank")){
								$error = true;
								$scatErr = "Pilih salah satu jenis subkategori";
							}else{
								$scat = $_POST['scat_id'];
							}
									
							if(trim($_POST['brand']=="blank")){
								$error = true;
								$brdErr = "Pilih salah satu tipe brand";
							}else{
								$brd = $_POST['brand'];
							}
									
							if(empty($_POST['size'])){
								$error = true;
								$sizeErr = "Harus di centangkan";
							}else{
								$size = $_POST['size'];
							}
							
							if(empty($_POST['color'])){
								$error = true;
								$clrErr = "Harus di centangkan";
							}else{
								$clr = $_POST['color'];
							}
									
							if(empty($_POST['detail'])){
								$error = true;
								$detailErr = "Masukkan isi detail";
							}else{
								$detail = $_POST['detail'];
								if(!preg_match("/^[a-zA-Z0-9 .,\-&]+$/i",$_POST['detail'])){
									$error = true;
									$detailErr = "Isi detail harus menggunakan huruf, karakter dan spasi";
								}
							}
							
							if(empty($_POST['matcar'])){
								$error = true;
								$matcarErr = "Masukkan isi bahan";
							}else{
								$matcar = $_POST['matcar'];
							}
									
							if(empty($_POST['price'])){
								$error = true;
								$priceErr = "Masukkan isi nominal harga";
							}else{
								$price = $_POST['price'];
								if(!is_numeric($price)){
									$error = true;
									$priceErr = "Isi harga menggunakan angka";
								}
							}
								
							if(empty($_POST['stock'])){
								$error = true;
								$stockErr = "Masukkan isi stok";
							}else{
								$stock = $_POST['stock'];
								if(!is_numeric($stock)){
									$error = true;
									$stockErr = "Isi stok menggunakan angka";
								}
							}
						}
						
						if(empty($_POST['available'])){
							$error = true;
							$availableErr = "Pilih mana yang aktif";
						}else{
							$available = $_POST['available'];
						}
						
						$bgImg = $_FILES['bg-img']['name'];
						$bgImgNew = date("md").$bgImg;
						
						if(move_uploaded_file($_FILES['bg-img']['tmp_name'],"img/".$bgImgNew)){
							$sql = mysqli_query($conn, "SELECT bgimg FROM items WHERE item_id = '".$id."'");
							$img = mysqli_fetch_array($sql);
									
							if(is_file("img/".$img['bgimg'])){
								unlink("img/".$img['bgimg']);
							}
							mysqli_query($conn,"UPDATE items SET bgimg='$bgImgNew' WHERE item_id='".$id."'");	
						}
						
						if(!$error){
							$size = implode(',', $_POST['size']);
							$clr = implode(',', $_POST['color']);
							$filename = implode(',',$_FILES['image']['name']);							
							
							foreach($_FILES['image']['error'] as $key => $error){
								if($error == UPLOAD_ERR_OK){
									$image = $_FILES['image']['name'][$key];
									$tmp = $_FILES['image']['tmp_name'][$key];
												
									$temp = explode(',', $data['image']);
									if(move_uploaded_file($tmp,"img/".$image)){
										for($i = 0; $i < count($temp); $i++){
											if(is_file("img/".trim($temp[$i]))){
												unlink("img/".trim($temp[$i]));
											}
											mysqli_query($conn,"UPDATE items SET image='$filename' WHERE item_id='".$id."'");
										}
									}
								}
							}
							
							mysqli_query($conn,"UPDATE items SET item_name='$item', cat_id='$cat', scat_id='$scat', brd_id='$brd', size='$size', clr_id='$clr', detail='$detail', material_care = '$matcar', price='$price', discount='$disc', stock='$stock', available ='$available' WHERE item_id='".$id."'");
							header('location: product.php');
						}
					}
					
		?>
						<form action="?act=edit&id=<?php echo $_GET['id'];?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
							<legend>Edit Topwear</legend>
							<!-- Kode Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Kode Produk</label>
								<div class="col-md-10">
									<input type="text" name="item_id" class="form-control" value="<?php echo $data['item_id']; ?>">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
								</div>
							</div>
							
							<!-- Nama Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nama Produk</label>
								<div class="col-md-10">
									<input type="text" name="item" class="form-control" placeholder="Item Name" value="<?php echo isset($_POST['item']) ? $_POST['item'] : $data['item_name'];?>">
									<span class="text-danger"><?php echo $itemErr ; ?></span>
								</div>
							</div>
							
							<!-- Tipe Kategori dan Subkategori -->
							<div class="form-group">
								<label class="col-md-2 control-label">Tipe Kategori dan Subkategori</label>
								<div class="col-md-3">
									<select name="cat_id" id="catid" class="form-control" onChange="showCategory(this.value);">
										<option value="blank">-- Pilih jenis kategori --</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM categories ORDER BY category ASC");
										while($cat = mysqli_fetch_array($query)){
											if($data['cat_id'] == $cat['cat_id']){
												echo "<option value='$cat[cat_id]' selected>$cat[category]</option>";
											}else{
												echo "<option value='$cat[cat_id]'>$cat[category]</option>";
											}
										}
										?>
									</select>
									<span class="text-danger"><?php echo $catErr ; ?></span>
								</div>
								<div class="col-md-3">
									<select name="scat_id" id="subcat" class="form-control">
										<option value="blank">-- Pilih jenis subkategori --</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM subcategories ORDER BY subcategory ASC");
										while($scat = mysqli_fetch_array($query)){
											if($data['scat_id'] == $scat['scat_id']){
												echo "<option value='$scat[scat_id]' selected>$scat[subcategory]</option>";
											}else{
												echo "<option value='$scat[scat_id]'>$scat[subcategory]</option>";
											}
										}
										?>
									</select>
									<span class="text-danger"><?php echo $scatErr ; ?></span>
								</div>
							</div>
							
							<!-- Pilihan Brand -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Tipe Brand</label>
								<div class="col-md-10">
									<select name="brand" class="form-control">
										<option value="blank">-- Pilih tipe brand--</option>
										<?php
										$query = mysqli_query($conn, "SELECT * FROM brands ORDER BY brand ASC");
										while($brd = mysqli_fetch_array($query)){
											if($data['brd_id'] == $brd['brd_id']){
												echo "<option value='$brd[brd_id]' selected>$brd[brand]</option>";
											}else{
												echo "<option value='$brd[brd_id]'>$brd[brand]</option>";
											}
										}
										mysqli_close($conn);
										?>
									</select>
									<span class="text-danger"><?php echo $brdErr ; ?></span>
								</div>
							</div>
							
							<!-- Size -->
							<div class="form-group">
								<label class="col-md-2 control-label">Size</label>
								<div class="col-md-10">
									<?php
									$sub = array_map('trim',explode(",",$data['size']));
									?>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="S" <?= (in_array('S',$sub)) ? 'checked' : NULL ?>>Small</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="M" <?= (in_array('M',$sub)) ? 'checked' : NULL ?>>Medium</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="L" <?= (in_array('L',$sub)) ? 'checked' : NULL ?>>Large</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="XL" <?= (in_array('XL',$sub)) ? 'checked' : NULL ?>>Xtra Large</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="XXL" <?= (in_array('XXL',$sub)) ? 'checked' : NULL ?>>Xtra-xtra Large</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="21" <?= (in_array('21',$sub)) ? 'checked' : NULL ?>>21</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="22" <?= (in_array('22',$sub)) ? 'checked' : NULL ?>>22</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="23" <?= (in_array('23',$sub)) ? 'checked' : NULL ?>>23</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="24" <?= (in_array('24',$sub)) ? 'checked' : NULL ?>>24</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="25" <?= (in_array('25',$sub)) ? 'checked' : NULL ?>>25</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="26" <?= (in_array('26',$sub)) ? 'checked' : NULL ?>>26</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="27" <?= (in_array('27',$sub)) ? 'checked' : NULL ?>>27</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="28" <?= (in_array('28',$sub)) ? 'checked' : NULL ?>>28</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="29" <?= (in_array('29',$sub)) ? 'checked' : NULL ?>>29</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="30" <?= (in_array('30',$sub)) ? 'checked' : NULL ?>>30</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="31" <?= (in_array('31',$sub)) ? 'checked' : NULL ?>>31</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="32" <?= (in_array('32',$sub)) ? 'checked' : NULL ?>>32</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="33" <?= (in_array('33',$sub)) ? 'checked' : NULL ?>>33</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="34" <?= (in_array('34',$sub)) ? 'checked' : NULL ?>>34</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="35" <?= (in_array('35',$sub)) ? 'checked' : NULL ?>>35</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="36" <?= (in_array('36',$sub)) ? 'checked' : NULL ?>>36</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="37" <?= (in_array('37',$sub)) ? 'checked' : NULL ?>>37</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="38" <?= (in_array('38',$sub)) ? 'checked' : NULL ?>>38</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="39" <?= (in_array('39',$sub)) ? 'checked' : NULL ?>>39</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="40" <?= (in_array('40',$sub)) ? 'checked' : NULL ?>>40</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="41" <?= (in_array('41',$sub)) ? 'checked' : NULL ?>>41</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="42" <?= (in_array('42',$sub)) ? 'checked' : NULL ?>>42</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="43" <?= (in_array('43',$sub)) ? 'checked' : NULL ?>>43</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="44" <?= (in_array('44',$sub)) ? 'checked' : NULL ?>>44</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="45" <?= (in_array('45',$sub)) ? 'checked' : NULL ?>>45</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="46" <?= (in_array('46',$sub)) ? 'checked' : NULL ?>>46</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="47" <?= (in_array('47',$sub)) ? 'checked' : NULL ?>>47</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="48" <?= (in_array('48',$sub)) ? 'checked' : NULL ?>>48</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="49" <?= (in_array('49',$sub)) ? 'checked' : NULL ?>>49</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="50" <?= (in_array('50',$sub)) ? 'checked' : NULL ?>>50</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="51" <?= (in_array('51',$sub)) ? 'checked' : NULL ?>>51</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="52" <?= (in_array('52',$sub)) ? 'checked' : NULL ?>>52</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="0-1Y" <?= (in_array('0-1Y',$sub)) ? 'checked' : NULL ?>>0-1Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="2-3Y" <?= (in_array('2-3Y',$sub)) ? 'checked' : NULL ?>>2-3Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="4-5Y" <?= (in_array('4-5Y',$sub)) ? 'checked' : NULL ?>>4-5Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="6-7Y" <?= (in_array('6-7Y',$sub)) ? 'checked' : NULL ?>>6-7Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="8-9Y" <?= (in_array('8-9Y',$sub)) ? 'checked' : NULL ?>>8-9Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="10-11Y" <?= (in_array('10-11Y',$sub)) ? 'checked' : NULL ?>>10-11Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="12-13Y" <?= (in_array('12-13Y',$sub)) ? 'checked' : NULL ?>>12-13Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="14-15Y" <?= (in_array('14-15Y',$sub)) ? 'checked' : NULL ?>>14-15Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="2Y" <?= (in_array('2Y',$sub)) ? 'checked' : NULL ?>>2Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="4Y" <?= (in_array('4Y',$sub)) ? 'checked' : NULL ?>>4Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="6Y" <?= (in_array('6Y',$sub)) ? 'checked' : NULL ?>>6Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="8Y" <?= (in_array('8Y',$sub)) ? 'checked' : NULL ?>>8Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="10Y" <?= (in_array('10Y',$sub)) ? 'checked' : NULL ?>>10Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="12Y" <?= (in_array('12Y',$sub)) ? 'checked' : NULL ?>>12Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="14Y" <?= (in_array('14Y',$sub)) ? 'checked' : NULL ?>>14Y</div>
									<div class="checkboxcss"><input type="checkbox" name="size[]" value="16Y" <?= (in_array('16Y',$sub)) ? 'checked' : NULL ?>>16Y</div>
									<br/>
									<span class="text-danger"><?php echo $sizeErr ; ?></span>
								</div>
							</div>
							
							<!-- Color -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Warna</label>
								<div class="col-md-10">
									<?php
									include "connect.php";
									$query = mysqli_query($conn, "SELECT * FROM colors");
									while($clr = mysqli_fetch_array($query)){
										$values_array = explode(',', $data['clr_id']);
									?>
										<div class="checkboxcss"><input type="checkbox" name="color[]" value="<?php echo $clr['clr_id']; ?>" <?php echo in_array($clr['clr_id'],$values_array) ? 'checked' : ''; ?>><span class="clrcode" style="background-color:<?php echo $clr['color_cd']; ?>"></span><?php echo $clr['color']; ?></div>
									<?php
									}
									?>
									<br/>
									<span class="text-danger"><?php echo $clrErr ; ?></span>
								</div>
							</div>
							
							<!-- Produk Gambar Single -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Gambar Single</label>
								<div class="col-md-10">
									<div id="image-preview-div">
										<?php
										echo '<img src="img/'.$data['bgimg'].'" class="preview-img">';
										?>
									</div>
									<input type="file" name="bg-img" id="imgjs">
								</div>
							</div>
							
							<!-- Produk Gambar Multiple -->
							<div class="form-group">
								<label class="col-md-2 control-label">Pilih Gambar Produk</label>
								<div class="col-md-10">
									<div id="preview">
										<?php
										$temp = explode(',', $data['image']);
										for($i = 0; $i < count($temp); $i++){
											echo '<img src="img/'.trim($temp[$i]).'" class="thumb-image-multiple">';
										}
										?>
									</div>
									<input type="file" name="image[]" id="image" multiple><button id="btnDelete" style="display:none;">Delete</button>
									<div id="message"></div>
								</div>
							</div>
							
							<!-- Detail Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Detail Produk</label>
								<div class="col-md-10">
									<textarea name="detail" rows="6" class="form-control"><?php echo isset($_POST['detail']) ? $_POST['detail'] : $data['detail'];?></textarea>
									<span class="text-danger"><?php echo $detailErr ; ?></span>
								</div>
							</div>
							
							<!-- Bahan dan Perawatan -->
							<div class="form-group">
								<label class="col-md-2 control-label">Bahan dan Perawatan</label>
								<div class="col-md-10">
									<textarea name="matcar" rows="4" class="form-control"><?php echo isset($_POST['matcar']) ? $_POST['matcar'] : $data['material_care'];;?></textarea>
									<span class="text-danger"><?php echo $matcarErr ; ?></span>
								</div>
							</div>
							
							<!-- Harga Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Harga Produk</label>
								<div class="col-md-2">
									<div class="input-group">
										<div class="input-group-addon"><span>Rp</span></div><input type="text" name="price" id="price" class="form-control" placeholder="Harga" value="<?php echo isset($_POST['price']) ? $_POST['price'] : $data['price'];?>">
									</div>
									<span class="text-danger"><?php echo $priceErr ; ?></span>
								</div>
							</div>
							
							<!-- Diskon -->
							<div class="form-group">
								<label class="col-md-2 control-label">Diskon</label>
								<div class="col-md-2">
									<div class="input-group">
										<input type="text" name="disc" class="form-control" placeholder="Discount" value="<?php echo isset($_POST['disc']) ? $_POST['disc'] : $data['discount'];?>"><span class="input-group-addon"><i>%</i></span>
									</div>
								</div>
							</div>
							
							<!-- Stok Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Stok Produk</label>
								<div class="col-md-2">
									<input type="text" name="stock" id="stock" class="form-control" placeholder="Stok" value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : $data['stock'];?>">
									<span class="text-danger"><?php echo $stockErr ; ?></span>
								</div>
							</div>
							
							<!-- Status Produk -->
							<div class="form-group">
								<label class="col-md-2 control-label">Status Produk</label>
								<div class="col-md-10">
									<div class="checkboxcss">
										<?php
										if($data['available'] == "Ada"){
											echo '<input type="radio" name="available" value="Ada" checked>Ada ';
											echo '<input type="radio" name="available" value="Habis">Habis ';
										}elseif($data['available'] == "Habis"){
											echo '<input type="radio" name="available" value="Ada">Ada ';
											echo '<input type="radio" name="available" value="Habis" checked>Habis ';
										}else{
											echo '<input type="radio" name="available" value="Ada">Ada ';
											echo '<input type="radio" name="available" value="Habis">Habis ';
										}
										?>
									</div>
									<span class="text-danger"><?php echo $availableErr ; ?></span>
								</div>
							</div>
							
							<!-- Button -->
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<button type="submit" class="btn btn-warning" name="update">Update</button>
									<a href="product.php"><button type="button" class="btn btn-link">Batal</button></a>
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
				$query = "DELETE FROM items WHERE item_id = '$id'";
				
				$sql = mysqli_query($conn, "SELECT bgimg, image FROM items WHERE item_id = '".$id."'");
				$img = mysqli_fetch_array($sql);
				
				if(is_file("img/".$img['bgimg'])){
					unlink("img/".$img['bgimg']);
				}
								
				$temp = explode(',', $img['image']);
				for($i = 0; $i < count($temp); $i++){
					if(is_file("img/".trim($temp[$i]))){
						unlink("img/".trim($temp[$i]));
					}
				}
				
				if(!$res = mysqli_query($conn,$query)){
					exit(mysqli_error());
				}
				header('location: product.php');
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