<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

ob_start();

include "../connect.php";
include "../library.php";
?>

<!DOCTYPE html>
<html>
<head>
	<!-- meta -->
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
	<title>MiiStore | Laporan Data Pemesanan</title>
	<meta name="keywords" content="men, women, clothing, home" />
	<meta name="author" content="Victory Webstore"/>
	
	<!-- mobile specific -->
	<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1" />
	
	<!-- Favicon -->
	<link rel="icon" href="../../logo/miistore-favicon.png" />
	
	<!-- CSS Offline -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css" />
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
	<style>
		@font-face {
			font-family: 'Source Sans Pro Light';
			src: url(../../fonts/sourcesanspro-light-webfont.ttf);
		}
		
		body{
		   font-family: 'Source Sans Pro Light', sans-serif !important;
		   font-weight: normal;
	   }
	   
		.table > thead > tr > th  {
		   text-align: center;
		   vertical-align: middle;
		   border: 1px solid #000;
		   color: #000;
	   }
	   
	   .table > tbody > tr > td {
		   vertical-align: middle;
		   border: 1px solid #000;
		   color: #000;
	   }
	   
	   img { display: -dompdf-image !important; }
	   
	   .logo-img {
		   margin-top: 15px;
		   display: block;
		   width: 150px;
	   }
	   
	</style>
</head>
<body>

	<section>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6">
					<img class="logo-img" src="../../logo/miistore1.png" />
				</div>
				<div class="col-sm-6 text-right" style="margin-top: 10px;">
					<address>
						Jl. Raya Condet Jakarta Timur<br/>
						Telepon : 021 23456789<br/>
						Email : info@miistore.com
					<address>
				</div>
				<div class="col-lg-12">
					<center><h1 style="color: #800000;">Laporan Data Pemesanan</h1></center>
					<div class="clearfix"></div>
					<table class="table table-bordered">
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
						<tbody>
						<?php
						$start = $_GET['tgl1'];
						$start_detail = date('Y-m-d', strtotime($start));
						$end = $_GET['tgl2'];
						$end_detail = date('Y-m-d', strtotime($end));
						$sql = '
								SELECT orders.*, members.fullname, order_detail.*,
								order_detail.price-(order_detail.price*order_detail.disc/100) AS hargadiskon 
								FROM orders INNER JOIN order_detail ON order_detail.order_id = orders.order_id INNER JOIN members ON members.member_id = orders.customer_id
								WHERE orders.creation_date BETWEEN "'.$start_detail.'" AND "'.$end_detail.'"
								';
						$query = mysqli_query($conn, $sql);
						while($row = mysqli_fetch_assoc($query)){
							$subtotal = $row['qty'] * $row['hargadiskon'];
							$total = $total + $subtotal;
							$totalqty = $totalqty + $row['qty'];
						?>
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
						<?php } ?>
							<tr>
								<td colspan="8" align="right">Total</td>
								<td align="center"><?php echo 'Rp '.number_format($total,0,".","."); ?></td>
							</tr>
						</tbody>
					</table>
					<div class="col-lg-12">
						<p>Jumlah/qty : <?php echo $totalqty; ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	
</body>
</html>

<?php
$html = ob_get_clean();

$dompdf = new DOMPDF();
$dompdf -> loadHtml($html);
$dompdf -> setPaper('letter', 'landscape');
$dompdf -> set_option('font_height_ratio', '0.70');
$dompdf -> render();
$font = $dompdf -> getFontMetrics() -> get_font("helvetica", "normal");
$dompdf -> getCanvas() -> page_text(45, 570, "MiiStore - Laporan Data Pemesanan", $font, 8, array(0,0,0));
$dompdf -> getCanvas() -> page_text(705, 570, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
$dompdf -> stream("order_report.pdf", array("Attachment" => false));
exit;
?>