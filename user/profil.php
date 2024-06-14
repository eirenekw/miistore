<?php ob_start(); ?>
<div class="container">
	<h1 class="well"><center>Profil Akun Saya</center></h1>
	<div class="col-lg-12 well">
		<div class="row">
			<?php
			$query = mysqli_query($conn, "SELECT * FROM members WHERE member_id = '".$member."'");
			$data = mysqli_fetch_array($query);
			
			if(!$query){
				printf("Error: %s\n", mysqli_error($conn));
				exit();
			}
			
			$error = false;
			$fname = $lname = $gender = $address = $city = $state = $zip = $phone = "";
			$fnameErr = $lnameErr = $genderErr = $addressErr = $cityErr = $stateErr = $zipErr = $phoneErr = "";
				
			if(isset($_POST['saveprofil'])){
								
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if(empty($_POST['fname'])){
						$error = true;
						$fnameErr = "Masukkan isi nama pertama Anda";
					}else{
						$fname = $_POST['fname'];
						if(!preg_match("/^[a-zA-Z .\-']*$/",$_POST['fname'])){
							$error = true;
							$fnameErr = "Isi nama harus menggunakan huruf, karakter dan spasi";
						}
					}
						
					if(empty($_POST['lname'])){
						$error = true;
						$lnameErr = "Masukkan isi nama terakhir Anda";
					}else{
						$lname = $_POST['lname'];
						if(!preg_match("/^[a-zA-Z .\-']*$/",$_POST['lname'])){
							$error = true;
							$lnameErr = "Isi nama harus menggunakan huruf, karakter dan spasi";
						}
					}
						
					if(trim($_POST['gender'])=="blank"){
						$error = true;
						$genderErr = "Pilih salah satu jenis kelamin Anda";
					}else{
						$gender = $_POST['gender'];
					}
					
					if(empty($_POST['address'])){
						$error = true;
						$addressErr = "Masukkan isi alamat Anda";
					}else{
						$address = $_POST['address'];
					}
						
					if(empty($_POST['city'])){
						$error = true;
						$cityErr = "Masukkan isi nama kota atau kabupaten";
					}else{
						$city = $_POST['city'];
						if(!preg_match("/^[a-zA-Z .\-,'&]*$/",$_POST['city'])){
							$error = true;
							$cityErr = "Isi nama kota atau kabupaten harus menggunakan huruf, karakter dan spasi";
						}
					}
						
					if(empty($_POST['state'])){
						$error = true;
						$stateErr = "Masukkan isi provinsi";
					}else{
							$state = $_POST['state'];
						if(!preg_match("/^[a-zA-Z .\-,'&]*$/",$_POST['state'])){
							$error = true;
							$stateErr = "Isi provinsi harus menggunakan huruf, karakter dan spasi";
						}
					}
						
					if(empty($_POST['postcode'])){
						$error = true;
						$zipErr = "Masukkan isi kode pos";
					}else{
						$zip = $_POST['postcode'];
						if(!is_numeric($zip)){
							$error = true;
							$zipErr = "Isi kode pos hanya menggunakan angka";
						}
					}
						
					if(empty($_POST['phone'])){
						$error = true;
						$phoneErr = "Masukkan isi nomor telepon";
					}else{
						$phone = $_POST['phone'];
						if(!is_numeric($phone)){
							$error = true;
							$phoneErr = "Isi nomor telepon hanya menggunakan angka";
						}
					}
				}
								
				if(!$error){
					$name = $fname." ".$lname;		
					mysqli_query($conn,"UPDATE members SET fullname = '".$name."', gender = '".$gender."', address = '".$address."', city = '".$city."', state = '".$state."', zip_code = '".$zip."', phone = '".$phone."' WHERE member_id = '".$member."'");		
					echo "<script>document.location = './index.php?p=profil'; </script>";
				}
			}
			list($fname, $lname) = explode(" ", $data['fullname']);
			?>
			<form action="./index.php?p=profil" method="POST">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Nama Depan :</label>
							<input type="text" class="form-control" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : $fname;?>">
							<span class="text-danger msg-error"><?php echo $fnameErr; ?></span>
						</div>
							
						<div class="col-sm-6 form-group">
							<label>Nama Belakang :</label>
							<input type="text" class="form-control" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : $lname;?>">
							<span class="text-danger msg-error"><?php echo $lnameErr; ?></span>
						</div>
					</div>
						
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Jenis Kelamin :</label>
							<select name="gender" class="form-control">
								<option value="blank">--- Pilih jenis kelamin Anda ---</option>
								<?php
								if($data['gender'] == "Laki-laki"){
									echo "<option value='Laki-laki' selected>Laki-laki</option>";
									echo "<option value='Perempuan'>Perempuan</option>";
								}elseif($data['gender'] == "Perempuan"){
									echo "<option value='Laki-laki'>Laki-laki</option>";
									echo "<option value='Perempuan' selected>Perempuan</option>";
								}else{
									echo "<option value='Laki-laki'>Laki-laki</option>";
									echo "<option value='Perempuan'>Perempuan</option>";
								}
								?>
							</select>
							<span class="text-danger msg-error"><?php echo $genderErr; ?></span>
						</div>
					</div>
						
					<div class="row">
						<div class="col-sm-12 form-group">
							<label>Alamat :</label>
							<input type="text" class="form-control" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : $data['address'];?>">
							<span class="text-danger msg-error"><?php echo $addressErr; ?></span>
						</div>
					</div>
						
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Kota / Kabupaten :</label>
							<input type="text" class="form-control" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : $data['city'];?>">
							<span class="text-danger msg-error"><?php echo $cityErr; ?></span>
						</div>
							
						<div class="col-sm-6 form-group">
							<label>Provinsi :</label>
							<input type="text" class="form-control" name="state" value="<?php echo isset($_POST['state']) ? $_POST['state'] : $data['state'];?>">
							<span class="text-danger msg-error"><?php echo $stateErr; ?></span>
						</div>
					</div>
						
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Kode Pos :</label>
							<input type="text" class="form-control" name="postcode" value="<?php echo isset($_POST['postcode']) ? $_POST['postcode'] : $data['zip_code'];?>">
							<span class="text-danger msg-error"><?php echo $zipErr; ?></span>
						</div>
							
						<div class="col-sm-6 form-group">
							<label>Nomor Telepon :</label>
							<input type="text" class="form-control" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $data['phone'];?>">
							<span class="text-danger msg-error"><?php echo $phoneErr; ?></span>
						</div>
					</div>
					<!-- Button -->
					<center>
						<div class="form-group">
							<button type="submit" class="btn btn-warning" name="saveprofil">Ubah Profil</button>
							<a href="./index.php"><button type="button" class="btn btn-link">Batal</button></a>
						</div>
					</center>
						
				</div>
			</form>
		</div>
	</div>
	<div class="well"><p class="text-center new-account">Apakah Anda yakin menghapus akun ini? <a href="./index.php?p=delete">Hapus Akun Anda</a></p></div>
</div>
<?php ob_end_flush(); ?>