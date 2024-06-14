<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="text-center text1">Brands</h2><br/>
		</div>
	</div>
	<div class="row" style="margin-bottom:20px;">
		<div class="col-md-4 col-xs-6">
		<?php
			$i = 1;
			$tmp = "";
			$query = mysqli_query($conn, "SELECT * FROM brands ORDER BY brand ASC");
			while($row = mysqli_fetch_assoc($query)){
				echo '<ul>';
				$first_letter = substr($row['brand'],0,1);
				if($tmp != $first_letter){
					$tmp = $first_letter;
					echo '<h4>'.$tmp.'</h4>';
				}
				echo '<li  style="list-style:none;"><a href="./index.php?p=productbrand&b='.$row['brand'].'">'.$row['brand'].'</a></li>';
				echo '</ul>';
				if($i % 8 == 0) echo '</div><div class="col-md-4 col-xs-6">';
				$i++;
			}
		?>
		</div>
	</div>
</div>
