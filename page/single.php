<?php ob_start(); ?>
<!-- Product Detail Single -->
<div class="product-detail">
	<div class="container">
		<div class="col-lg-12">
			<?php
				$id = $_GET['id'];
		
				$query = mysqli_query($conn, "SELECT * FROM items WHERE item_id = '".$id."'");
				$data = mysqli_fetch_array($query);
				
			?>
			<div class="back-right"><a href="./index.php"><i class="fa fa-arrow-left"></i> BACK</a></div>
			<div class="col-md-4 single-left">
				<div class="flexslider">
					<ul class="slides">
					<?php
						$temp = explode(',', $data['image']);
						for($i = 0; $i < count($temp); $i++){
							echo '<li data-thumb="./miiadmin/img/'.trim($temp[$i]).'"><div class="thumb-image"><img src="./miiadmin/img/'.trim($temp[$i]).'" 
							class="img-responsive" /></div></li>';
						}
					?>
					</ul>
				</div>
			</div>
			<div class="col-md-8 single-right">
			<form action="./index.php?p=single&id=<?php echo $_GET['id']; ?>" method="POST">
				<label><h3><?php echo $data['item_name']; ?></h3></label>
				<p class="availability">Status Stok: <span class="color"><?php echo $data['available'];?></span></p>
				<div class="price_single">
					<?php 
					$totalDisc = $data['price']-($data['price']*$data['discount']/100); 
					if($data['discount'] == "0"){
						echo '<h4>Harga Normal</h4>';
						echo '<span class="actual">Rp '.number_format($data['price'],0,".",".").'</span>';
					}else{
						echo '
						<h4>Harga Spesial</h4>
						<span class="actual">Rp '.number_format($totalDisc,0,".",".").'</span>
						<span class="reducedfrom"><strike>Rp '.number_format($data['price'],0,".",".").'</strike></span>
						<span class="discoff">'.$data['discount'].'%</span>
						';
					}
					?>
				</div>
				<div class="detail">
					<h4>Produk Detail</h4>
					<p><?php echo $data['detail']; ?></p>
				</div>
				<div class="detail">
					<h4>Bahan dan Perawatan</h4>
					<p><?php echo nl2br($data['material_care']); ?></p>
				</div>
				<?php
				if($data['clr_id'] != "0"){
					echo '
					<div class="product-colors">
						<h4>Color</h4>
					';
						$colors = explode(',',$data['clr_id']);
						foreach($colors as $c){
							$query = mysqli_query($conn, "SELECT * FROM colors");
							while($clr = mysqli_fetch_array($query)){
								if($c == $clr['clr_id']){
									echo '<div class="check-color"><input type="checkbox" name="color-item" id="'.$clr['color'].'" value="'.$clr['color'].'"><label for="'.$clr['color'].'" style="background-color:'.$clr['color_cd'].';"></label></div>';
								}
							}
						}
					echo '</div>';
				}
				?>
					
				<div class="product-size">
					<h4>Size</h4>
					<?php $sizes = explode(',',$data['size']);
					foreach($sizes as $s){
						echo '<div class="check-size"><label for="'.$s.'"><input type="radio" name="size-item" value="'.$s.'" id="'.$s.'"><span>'.$s.'</span></label></div>';
					}
					?>
				</div>
					
				<div class="qty">
					<h4>Jumlah</h4>
					<div class="number"><input type="number" name="qty" min="0" max="<?php echo $data['stock']; ?>"></div>
				</div>
				
				<input type="hidden" name="hidden_id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="hidden_img" value="<?php echo $data['bgimg']; ?>"/>
				<input type="hidden" name="hidden_name" value="<?php echo $data['item_name']; ?>"/>
				<input type="hidden" name="hidden_price" value="<?php echo $data['price']; ?>"/>
				<input type="hidden" name="hidden_disc" value="<?php echo $data['discount']; ?>"/>
				<input type="submit" name="cart" value="Beli sekarang" class="btn-checkout-2">
				</form>

				<?php
				if(isset($_POST['cart'])){
					$error = false;
					foreach($_POST as $val){
						if(trim($val) == "" & empty($val)){
							$error = true;
						}
					}
					if($error){
						echo '<div class="modal fade" id="fields" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title">Info</h4>
											</div>
											<div class="modal-body">
												<h3>Isikan dulu</h3>
											</div>
											<div class="modal-footer">
												<a href="./index.php?p=single&id='.$_GET['id'].'" class="btn btn-info">OK</a>
											</div>
										</div>
									</div>
								</div>';
					}else{
						if(isset($_SESSION['cart'])){
							$count = count($_SESSION['cart']);
							$is_available = 0;
							foreach ($_SESSION["cart"] as $keys => $values){
								if($_SESSION['cart'][$keys]['product_id'] == $_GET['id'] && $_SESSION['cart'][$keys]['color'] == $_POST['color-item'] && $_SESSION['cart'][$keys]['size'] == $_POST['size-item']){
									$is_available++;
									$_SESSION['cart'][$keys]['qty'] = $_SESSION['cart'][$keys]['qty'] + $_POST['qty'];
								}
							}
							if($is_available < 1){
								$item_array = array(
								'product_id' => $_GET['id'], 
								'item_img' => $_POST['hidden_img'], 
								'item_name' => $_POST['hidden_name'], 
								'color' => $_POST['color-item'],
								'size' => $_POST['size-item'],
								'qty' => $_POST['qty'],
								'disc' => $_POST['hidden_disc'],
								'price' => $_POST['hidden_price']
								);
								
								$_SESSION['cart'][$count] = $item_array;
							}	
						}else{
							$item_array = array(
								'product_id' => $_GET['id'], 
								'item_img' => $_POST['hidden_img'], 
								'item_name' => $_POST['hidden_name'], 
								'color' => $_POST['color-item'],
								'size' => $_POST['size-item'],
								'qty' => $_POST['qty'],
								'disc' => $_POST['hidden_disc'],
								'price' => $_POST['hidden_price']
								);
								$_SESSION['cart'][0] = $item_array;
						}
						echo "<script>document.location = './index.php?p=cart'; </script>";
					}
				}
				?>
				
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php ob_end_flush(); ?>