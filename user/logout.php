<?php
session_start();

setcookie('email','', time() -3600);
session_destroy();

echo "<script>document.location = './index.php'; </script>";
?>

