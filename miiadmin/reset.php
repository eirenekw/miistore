<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();

include "connect.php";

if(isset($_SESSION['username']) && $_SESSION['username'] != ''){
	$user = $_SESSION['username'];
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
	<title>Reset Kata Sandi</title>
	<meta name="keywords" content="men, women, clothing, home" />
	<meta name="author" content="Victory Webstore"/>
	
	<!-- mobile specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="../logo/miistore-favicon.png" />
	
	<!-- CSS Offline -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/miiadmin.css" />
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
	
</head>
<body class="background-black">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<!-- Logo -->
				<img class="logo-title" src="../logo/miistore3.png" />
				<!-- Form -->
				<div class="account-wall">
					<?php
					$error = false;
					$pass = "";
					$passErr = $cpassErr = "";
					
					if(isset($_POST['newpass'])){
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							if(empty($_POST['pass'])){
								$error = true;
								$passErr = "Masukkan isi kata sandi baru";
							}else{
								$pass = md5($_POST['pass']);
								if(strlen($_POST['pass']) < 6){
									$error = true;
									$passErr = "Isi kata sandi harus minimal 6 karakter";
								}
							}
										
							if(empty($_POST['cpass'])){
								$error = true;
								$cpassErr = "Masukkan isi konfirmasi kata sandi";
							}else{
								if($_POST['pass'] != $_POST['cpass']){
									$error = true;
									$cpassErr = "Kata sandi dan konfirmasi kata sandi tidak cocok";
								}
							}
						}
						
						if(!$error){
							mysqli_query($conn,"UPDATE users SET pass='".$pass."' WHERE user='".$user."'");
							$error = true;
							echo "<div class='alert alert-success'>Kata sandi Anda berhasil di ubah</div>";
						}
					}
					?>
					<form action="reset.php" method="post">
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-key"></i></span>
							<input type="password" class="form-control form-input" name="pass" placeholder="Masukkan isi kata sandi baru">
						</div>
						<span class="text-danger msg-error"><?php echo $passErr; ?></span>
						
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control form-input" name="cpass" placeholder="Ulangi kata sandi lagi">
						</div>
						<span class="text-danger msg-error"><?php echo $cpassErr; ?></span>
						
						<button type="submit" class="btn btn-lg btn-primary btn-block" name="newpass">Ubah Kata Sandi</button>
					</form>
				</div>
				<p class="text-center new-account">Pernah jadi anggota? <a href="index.php">Masuk</a></p>
				<p class="text-center new-account">Sudahkah Anda mendaftar belum? <a href="index.php?signup">Buat akun baru</a></p>
			</div>
		</div>
	</div>
	<!-- JS Offline -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>