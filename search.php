<div class="top-products">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="text-center text1">Semua Produk</h2>
			</div>
		</div>
		<div class="row product">
<?php
include "connect.php";
$key = $_GET['key'];

$query = mysqli_query($conn, "SELECT * FROM items WHERE item_name LIKE '%{$key}%'");
while($row = mysqli_fetch_array($query)){
	$totalDisc = $row['price']-($row['price'] * $row['discount']/100);
	echo '<div class="col-md-3 col-xs-6 product-left">
					<div class="p-one">
						<a href="#">
							<img src="miiadmin/img/'.$row['bgimg'].'"/>
							<div class="mask">
								<a href="index.php?p=single&id='.$row['item_id'].'"><span>Quick View</span></a>
							</div>
						</a>
						<h4>'.$row['item_name'].'</h4>
						<div class="item_price">
							<p>
								<i>Rp '.number_format($row['price'],0,".",".").'</i>
								<span>Rp '.number_format($totalDisc,0,".",".").'</span>
							</p>
						</div>
					</div>
				</div>';
}
?>
		</div>
	</div>
</div>
<div class="clearfix"></div>