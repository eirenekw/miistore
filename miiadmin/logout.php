<?php
session_start();

setcookie('user_id','', time() - 3600);
session_destroy();

echo "<script>document.location = 'index.php'; </script>";
?>

