<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

ob_start();

include "../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
	<!-- meta -->
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
	<title>MiiStore | Daftar Kontak Pelanggan</title>
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
					<center><h1 style="color: #800000;">Daftar Kontak Pelanggan</h1></center>
					<div class="clearfix"></div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="10">#</th>
								<th>Kode Pelanggan</th>
								<th>Nama Pelanggan</th>
								<th>Telepon</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$sql = "SELECT * FROM members";
						$query = mysqli_query($conn, $sql);
						$no = 0;
						while($row = mysqli_fetch_assoc($query)){
						?>
							<tr>
								<td width="10" align="center"><?php echo ++$no; ?></td>
								<td align="center"><?php echo $row['member_id']; ?></td>
								<td><?php echo $row['fullname']; ?></td>
								<td align="center"><?php echo $row['phone']; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
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
$dompdf -> getCanvas() -> page_text(45, 570, "MiiStore - Daftar Kontak Pelanggan", $font, 8, array(0,0,0));
$dompdf -> getCanvas() -> page_text(705, 570, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
$dompdf -> stream("item_report.pdf", array("Attachment" => false));
exit;
?>