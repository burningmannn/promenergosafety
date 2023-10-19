<?php 
	$login = filter_var(trim($_POST["login"]),FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST["pass"]),FILTER_SANITIZE_STRING);

	$r_host = "localhost";
	$r_user = "root";
	$r_password = "";
	$r_database = "prom";
	$check = new mysqli($r_host,$r_user,$r_password,$r_database);

	$result = mysqli_query($check,"SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
   // var_dump($result);
	$user = $result->fetch_assoc();
	if ($user == 0){
		header('Location: ../admin.php');
		echo "Такой пользователь не найден!";
		exit();
	} 

	setcookie('user',$user['name'], time() + 36000, "/");

	header('Location: ../index.php');
?>