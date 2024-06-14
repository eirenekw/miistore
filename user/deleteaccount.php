<?php ob_start(); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="text-center text1">Peringatan!</h2>
		</div>
		<div class="col-lg-12 text-center">
			<b>Yakin ingin menonaktifkan akun Anda?</b><br/>
			<p>Jika akun Anda dinonaktifkan, profil Anda akan dihapus selamanya. <br/>
			<form action="./index.php?p=delete" method="POST" style="margin-bottom: 5%;">
				<input type="submit" class="btn btn-warning" name="deactivated" value="Tutup Akun"/>
				<a href="./index.php"><button type="button" class="btn btn-link">Tidak</button></a>
			</form>
			<?php
			if(isset($_POST['deactivated'])){
				$query = "DELETE FROM members WHERE member_id = '$member'";
				if(!$res = mysqli_query($conn,$query)){
					exit(mysqli_error());
				}
				setcookie('email','', time() -3600);
				session_destroy();
				echo "<script>document.location = './index.php'; </script>";
			}
			?>
		</div>
	</div>
</div>
<?php ob_end_flush(); ?>