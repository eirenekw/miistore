<div class="container">
	<h1 class="well"><center>Masuk dengan MiiStore</center></h1>
	<div class="col-lg-12 well">
		<div class="row">
		<?php
		$error = false;
		$emailErr = $passErr = "";
			
		if(isset($_POST['signin'])){
			$email = mysqli_real_escape_string($conn, trim($_POST['email']));
			$password = mysqli_real_escape_string($conn, md5($_POST['password']));
			$remember = "";
				
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if(empty($_POST['email'])){
					$error = true;
					$emailErr = "Masukkan isi alamat email";
				}
												
				if(empty($_POST['password'])){
					$error = true;
					$passErr = "Masukkan isi kata sandi";
				}
			}
				
			if(!$error){
				if($email && $password){
					$login = mysqli_query($conn,"SELECT * FROM members WHERE email='".$email."'");
					while($row=mysqli_fetch_assoc($login)){
						$member = $row['member_id'];
						$name = $row['fullname'];
						$db_pass = $row['password'];
						if($password == $db_pass){
							$loginok = TRUE;
						}else{
							$loginok = FALSE;
						}
							
						if($loginok == TRUE){
							if($remember == "on"){
								setcookie("member_id", $member, time() + (86400*30));
								setcookie("fullname", $name, time() + (86400*30));
								setcookie("email", $email, time() + (86400*30));
							}elseif($remember == ""){
								$_SESSION['member_id'] = $member;
								$_SESSION['fullname'] = $name;
								$_SESSION['email'] = $email;
							}
							echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
						}else{
							$error = true;
							echo "<div class='alert alert-danger'>Email dan kata sandi Anda salah, Silakan coba lagi!</div>";
						}
					}
				}
			}		
		}
		?>
			<form action="./index.php?p=login" method="POST">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label>Email :</label>
							<input type="text" class="form-control" name="email" placeholder="Masukkan isi email">
							<span class="text-danger msg-error"><?php echo $emailErr; ?></span>
						</div>
								
						<div class="col-sm-6 form-group">
							<label>Kata Sandi :</label>
							<div class="input-group">
								<input type="password" id="password" name="password" class="form-control">
								<div class="input-group-addon">
									<span>Show</span>
								</div>
							</div>
							<span class="text-danger msg-error"><?php echo $passErr; ?></span>
						</div>
					</div>
							
					<div class="row">
						<div class="col-sm-6 form-group">
							<div class="checkboxcss"><input type="checkbox" name="remember" value="on"> Ingat Saya</div>
						</div>
					</div>
							
					<!-- Button -->
					<center>
						<div class="form-group">
							<button type="submit" class="btn btn-warning" name="signin">Masuk</button>
							<a href="./index.php"><button type="button" class="btn btn-link">Batal</button></a>
						</div>
					</center>
							
				</div>
			</form>
		</div>
	</div>
	<div class="well"><p class="text-center new-account">Sudahkah Anda mendaftar belum? <a href="./index.php?p=register">Buat akun baru</a></p></div>
</div>