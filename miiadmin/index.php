<?php
error_reporting(E_ALL ^ E_NOTICE);

session_start();

if((isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != '') || (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '')){
	header('location: miadmin.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	<meta name="keywords" content="men, women, clothing, home" />
	<meta name="author" content="Eirene KW"/>
	
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
	<?php
	include "connect.php";
	
	switch($_SERVER['QUERY_STRING']){
		default:
	?>

	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<!-- Logo -->
				<img class="logo-title" src="../logo/miistore3.png" />
				<!-- Form -->
				<div class="account-wall">
				<?php
					
					$error = false;
					$userErr = $passErr = "";
					
					if(isset($_POST['signin'])){
						$user = trim($_POST['username']);
						$password = md5($_POST['password']);
						$remember = "";
						
						$user = mysqli_real_escape_string($conn, $user);
						$password = mysqli_real_escape_string($conn, $password);
						
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							if(empty($_POST['username'])){
								$error = true;
								$userErr = "Masukkan isi nama pengguna Anda";
							}
							
							if(empty($_POST['password'])){
								$error = true;
								$passErr = "Masukkan isi kata sandi";
							}
						}
						
						if(!$error){
							if($user && $password){
								
								$login = mysqli_query($conn,"SELECT * FROM users WHERE user='".$user."'");
								if(mysqli_num_rows($login) > 0){
									while($row=mysqli_fetch_assoc($login)){
										$id = $row['user_id'];
										$name = $row['fullname'];
										$db_pass = $row['pass'];
										if($password == $db_pass){
											$loginok = TRUE;
										}else{
											$loginok = FALSE;
										}
										
										if($loginok == TRUE){
											if($remember == "on"){
												setcookie("user_id", $id, time() + (86400*30));
												setcookie("fullname", $name, time() + (86400*30));
												setcookie("user", $user, time() + (86400*30));
											}elseif($remember == ""){
												$_SESSION['user_id'] = $id;
												$_SESSION['fullname'] = $name;
												$_SESSION['user'] = $user;
											}
											echo "<meta http-equiv='refresh' content='0; url=miadmin.php'>";
										}else{
											$error = true;
											echo "<div class='alert alert-danger'>Nama pengguna dan kata sandi Anda salah, silakan coba lagi!</div>";
										}
									}
								}else{
									$error = true;
									echo "<div class='alert alert-danger'>Mohon maaf data Anda tidak di temukan!</div>";
								}
							}
						}
						
					}
				?>
					<form action="index.php" method="post">
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control form-input" name="username" placeholder="Masukkan isi nama pengguna Anda">
						</div>
						<span class="text-danger msg-error"><?php echo $userErr; ?></span>
						
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control form-input" id="form-password" name="password" placeholder="Masukkan isi kata sandi">
						</div>
						<div class="checkboxcss" style="color:#FFF; float:right;"><input type="checkbox" onchange="document.getElementById('form-password').type = this.checked ? 'text' : 'password'">Lihat Kata Sandi</div>
						<span class="text-danger msg-error"><?php echo $passErr; ?></span>
						
						<div class="form-group">
							<div class="checkboxcss" style="color:#FFF;"><input type="checkbox" name="remember" value="on">Ingat Saya</div>
						</div>
						<button type="submit" class="btn btn-lg btn-primary btn-block" name="signin">Masuk</button>
					</form>
				</div>
				<p class="text-center new-account">Sudahkah Anda mendaftar belum? <a href="?signup">Buat akun baru</a></p>
				<p class="text-center new-account"><a href="?resetuser">Reset Kata Sandi</a></p>
			</div>
		</div>
	</div>
	<?php
		break;
		case 'signup';
	?>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<!-- Logo -->
				<img class="logo-title" src="../logo/miistore3.png" />
				<!-- Form -->
				<div class="account-wall">
				<?php
				$error = false;
				$name = $user = $pass = "";
				$nameErr = $userErr = $passErr = $cpassErr = "";
							
				if(isset($_POST['signup'])){
					$query = mysqli_query($conn,"SELECT * FROM users WHERE user='".$_POST['user']."'");
								
					if($_SERVER['REQUEST_METHOD'] == "POST"){
						if(empty($_POST['fullname'])){
							$error = true;
							$nameErr = "Masukkan isi nama lengkap Anda";
						}else{
							$name = $_POST['fullname'];
							if(!preg_match("/^[a-zA-Z .\-']*$/",$_POST['fullname'])){
								$error = true;
								$nameErr = "Isi nama lengkap harus menggunakan huruf, karakter dan spasi";
							}
						}
									
						if(empty($_POST['user'])){
							$error = true;
							$userErr = "Masukkan isi nama pengguna Anda";
						}else{
							$user = $_POST['user'];
							if(!preg_match("/^[a-z0-9]*$/",$_POST['user'])){
								$error = true;
								$userErr = "Isi nama pengguna harus menggunakan huruf kecil dan angka";
							}
						}
									
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
						$name = mysqli_real_escape_string($conn, $name);
						$user = mysqli_real_escape_string($conn, $user);
						$pass = mysqli_real_escape_string($conn, $pass);
						if(mysqli_num_rows($query) > 0){
							echo "<div class='alert alert-danger'>Nama pengguna sudah masih ada, mohon di buat yang lain!</div>";
						}else{
							mysqli_query($conn,"INSERT INTO users VALUES (null,'$name','$user','$pass')");
							echo "<meta http-equiv='refresh' content='0; url=index.php'>";
						}
					}
				}
				?>
				<form action="?signup" method="post">
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control form-input" name="fullname" placeholder="Masukkan isi nama lengkap Anda">
						</div>
						<span class="text-danger msg-error"><?php echo $nameErr; ?></span>
						
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control form-input" name="user" placeholder="Masukkan isi nama pengguna Anda">
						</div>
						<span class="text-danger msg-error"><?php echo $userErr; ?></span>
						
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-key"></i></span>
							<input type="password" class="form-control form-input" name="pass" placeholder="Masukkan isi kata sandi">
						</div>
						<span class="text-danger msg-error"><?php echo $passErr; ?></span>
						
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control form-input" name="cpass" placeholder="Ulangi kata sandi lagi">
						</div>
						<span class="text-danger msg-error"><?php echo $cpassErr; ?></span>
						
						<button type="submit" class="btn btn-lg btn-primary btn-block" name="signup">Daftar</button>
					</form>
				</div>
				<p class="text-center new-account">Pernah jadi anggota? <a href="/miiadmin/index.php">Masuk</a></p>
			</div>
		</div>
	</div>
<?php
		break;
		case "resetuser";
?>
		<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<!-- Logo -->
				<img class="logo-title" src="../logo/miistore3.png" />
				<!-- Form -->
				<div class="account-wall">
					<?php
					$error = false;
					$user = "";
					$userErr = "";
					
					if(isset($_POST['reset'])){
						if($_SERVER['REQUEST_METHOD'] == "POST"){
							if(empty($_POST['user'])){
								$error = true;
								$userErr = "Masukkan isi nama pengguna Anda";
							}else{
								$user = $_POST['user'];
								if(!preg_match("/^[a-z0-9]*$/",$_POST['user'])){
									$error = true;
									$userErr = "Isi nama pengguna harus menggunakan huruf kecil dan angka";
								}
							}
						}
						
						if(!$error){
							if($user){
								$login = mysqli_query($conn,"SELECT * FROM users WHERE user='".$user."'");
								$result = mysqli_num_rows($login);
								if($result > 0){
									session_start();
									$_SESSION['username'] = $user;
									echo "<meta http-equiv='refresh' content='0; url=reset.php'>";
								}else{
									$error = true;
									echo "<div class='alert alert-danger'>Nama pengguna Anda salah, silakan coba lagi!</div>";
								}
							}
						}
					}
					?>
					<form action="?resetuser" method="post">
						<div class="form-group input-group groups">
							<span class="input-group-addon icons"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control form-input" name="user" placeholder="Masukkan isi nama pengguna Anda">
						</div>
						<span class="text-danger msg-error"><?php echo $userErr; ?></span>
						
						<button type="submit" class="btn btn-lg btn-primary btn-block" name="reset">Reset</button>
					</form>
				</div>
				<p class="text-center new-account">Pernah jadi anggota? <a href="index.php">Masuk</a></p>
				<p class="text-center new-account">Sudahkah Anda mendaftar belum? <a href="?signup">Buat akun baru</a></p>
			</div>
		</div>
	</div>
<?php
		break;
	}
?>
	
	<!-- JS Offline -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
</body>
</html>