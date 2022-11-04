<?php 
	setcookie('user', 'no', time() - 3600, "/");

	header('Location: ../index.php');
?>