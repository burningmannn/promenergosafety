<?php 
	$name = filter_var(trim($_POST["name"]),FILTER_SANITIZE_STRING);
	$login = filter_var(trim($_POST["login"]),FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST["pass"]),FILTER_SANITIZE_STRING);

	if(mb_strlen($name) < 5 || mb_strlen($login) > 20){
		echo "Введите имя другой длины от 5 до 20 символов";
		exit();
	} else if(mb_strlen($login) < 5 || mb_strlen($login) > 20){
		echo "Введите логин другой длины от 5 до 20 символов";
		exit();
	} else if(mb_strlen($pass) < 5 || mb_strlen($pass) > 20){
		echo "Введите пароль другой длины от 5 до 20 символов";
		exit();
	}

	$r_host = "localhost";
	$r_user = "root";
	$r_password = "";
	$r_database = "prom";
	$check = new mysqli($r_host,$r_user,$r_password,$r_database);

	mysqli_query($check,"INSERT INTO `users` (`id`, `name`, `login`, `pass`) VALUES(NULL, '$name', '$login', '$pass')");

	header('Location: ../index.php');
?>