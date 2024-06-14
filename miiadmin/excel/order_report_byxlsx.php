<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Asia/Jakarta');

ob_start();
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
include "../connect.php";
include "../library.php";

$objPHPExcel = new PHPExcel();

$objPHPExcel -> getProperties() -> setCreator('Victory Webstore') 
                                           -> setLastModifiedBy('Victory Webstore') 
									       -> setTitle('Laporan Data Pemesanan');
										   
$styleArray = array('font' => array('size' => 11), 
					'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
					
$styleArray2 = array('font' => array('size' => 11, 'name' => 'Source Sans Pro'), 
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
										   
$activesheet = $objPHPExcel -> setActiveSheetIndex(0);
$sheet = $objPHPExcel -> getActiveSheet();

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing -> setName('MiiStore');
$objDrawing -> setPath('../../logo/miistore1.png');
$objDrawing -> setCoordinates('A2');
$objDrawing -> setWidthAndHeight(180,77);
$objDrawing -> setResizeProportional(true);
$objDrawing -> setWorksheet($objPHPExcel -> getActiveSheet());

$sheet -> setCellValue('A6', 'LAPORAN DATA PEMESANAN');
$sheet -> mergeCells('A6:H6');
$sheet -> getStyle('A6') -> getFont() -> setBold(true);
$sheet -> getStyle('A6') -> getFont() -> setSize(16);
$sheet -> getStyle('A6') -> getFont() -> setName('Source Sans Pro Light');
$sheet -> getStyle('A6') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$activesheet -> setCellValue('F2', 'Jl. Raya Condet Jakarta Timur')
				  -> setCellValue('F3', 'Telepon : 021 23456789')
				  -> setCellValue('F4', 'Email : info@miistore.com');

$sheet -> mergeCells('F2:H2');				  
$sheet -> mergeCells('F3:H3');				  
$sheet -> mergeCells('F4:H4');	  
$sheet -> getStyle('F2:H4') -> applyFromArray($styleArray2);
				  
$rowNumber = 8;
$query = 'SELECT o1.creation_date, o1.order_id, o1.fullname, o1.item_name, o1.size, o1.color, o1.qty, o1.price, o1.disc, o1.total FROM 
			 (SELECT orders.creation_date, orders.order_id, 
			 CONCAT(members.fullname, "(", orders.customer_id, ")") AS fullname, 
			 GROUP_CONCAT(CONCAT(order_detail.item_name, "(", order_detail.item_code, ")") SEPARATOR ",") AS item_name, 
			 GROUP_CONCAT(order_detail.size) AS size,
			 GROUP_CONCAT(order_detail.color) AS color,
			 GROUP_CONCAT(order_detail.qty) AS qty,
			 GROUP_CONCAT(order_detail.price) AS price, 
			 GROUP_CONCAT(order_detail.disc) AS disc,
			 SUM(order_detail.qty * order_detail.price -(order_detail.price * order_detail.disc / 100)) AS total
			 FROM order_detail INNER JOIN orders ON orders.order_id = order_detail.order_id 
			 INNER JOIN members ON members.member_id = orders.customer_id GROUP BY orders.order_id) o1';
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)){
	$date = fixdate($row['creation_date']);
	$product = explode(",", $row['item_name']);
	$size = explode(",", $row['size']);
	$color = explode(",", $row['color']);
	$qty = explode(",",$row['qty']);
	$price = explode(",", $row['price']);
	$disc = explode(",", $row['disc']);
	
	$sheet -> setCellValue('A'.$rowNumber, "Tanggal Pemesan: ".$date."\nKode Pemesan: ".$row['order_id']."\nNama Pelanggan : ".$row['fullname']);
	$sheet -> getStyle('A'.$rowNumber) -> getAlignment() -> setWrapText(true);
	$sheet -> getRowDimension($rowNumber) -> setRowHeight(45);
	$sheet -> mergeCells('A'.$rowNumber.':H'.$rowNumber);
	$sheet -> getStyle('A'.$rowNumber.':H'.$rowNumber) -> applyFromArray($styleArray);
	
	$activesheet -> setCellValue('A'.($rowNumber+1), 'Nama Produk')
					  -> setCellValue('B'.($rowNumber+1), 'Ukuran')
					  -> setCellValue('C'.($rowNumber+1), 'Warna')
					  -> setCellValue('D'.($rowNumber+1), 'Jumlah')
					  -> setCellValue('E'.($rowNumber+1), 'Harga')
					  -> setCellValue('F'.($rowNumber+1), 'Diskon')
					  -> setCellValue('G'.($rowNumber+1), 'Harga Promo')
					  -> setCellValue('H'.($rowNumber+1), 'Subtotal');
	$sheet -> getStyle('A'.($rowNumber+1).':H'.($rowNumber+1)) -> applyFromArray($styleArray);
	$sheet -> getStyle('A'.($rowNumber+1).':H'.($rowNumber+1)) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					  
	$x = $rowNumber+2;
	$xx = $rowNumber+3;
	for($i = 0; $i < count($product); $i++){
		$activesheet -> setCellValue('A'.$x, $product[$i])
						  -> setCellValue('B'.$x, $size[$i])
						  -> setCellValue('C'.$x, $color[$i])
						  -> setCellValue('D'.$x, $qty[$i])
						  -> setCellValue('E'.$x, $price[$i])
						  -> setCellValue('F'.$x, '='.$disc[$i].'/100')
						  -> setCellValue('G'.$x, '=E'.$x.'-(E'.$x.'*F'.$x.')')
						  -> setCellValue('H'.$x, '=G'.$x.'*D'.$x);
		
		$sheet -> getStyle('E'.$x) -> getNumberFormat() -> setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_("0";_(@_)');
		$sheet -> getStyle('F'.$x) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		$sheet -> getStyle('G'.$x.':H'.$x) -> getNumberFormat() -> setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_("0";_(@_)');
		
		$sheet -> getStyle('A'.$x.':H'.$x) -> applyFromArray($styleArray);
		$sheet -> getStyle('B'.$x.':D'.$x) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet -> getStyle('F'.$x) -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$activesheet -> setCellValue('G'.$xx, 'Total')
						  -> setCellValue('H'.$xx, $row['total']);
		$sheet -> getStyle('H'.$xx) -> getNumberFormat() -> setFormatCode('_(Rp* #,##0_);_(Rp* (#,##0);_("0";_(@_)');
		$sheet -> getStyle('G'.$xx.':H'.$xx) -> applyFromArray($styleArray);
		$x++;
		$xx++;
	}
	
	$rowNumber+=6;
}
$sheet -> getColumnDimension('A') -> setWidth(48);
foreach(range('B','H') as $columnID){
	$sheet -> getColumnDimension($columnID) -> setAutoSize(true);
}

$sheet -> setTitle('order_report');

$sheet -> getPageSetup() -> setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet -> getPageSetup() -> setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$sheet -> getPageMargins() -> setHeader(0.31);
$sheet -> getPageMargins() -> setTop(0.59);
$sheet -> getPageMargins() -> setRight(0.61);
$sheet -> getPageMargins() -> setLeft(0.62);
$sheet -> getPageMargins() -> setBottom(0.59);
$sheet -> getPageMargins() -> setFooter(0.31);

$sheet -> getHeaderFooter() -> setOddFooter('&LMiiStore - Laporan Data Pemesanan &RPage &P / &N');

#echo date('H:i:s'). "Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

ob_end_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="order_report_byxlsx.xlsx"');

$objWriter -> save('php://output');
exit;
?>