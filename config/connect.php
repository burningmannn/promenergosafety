<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_database = "prom";
$connect = mysqli_connect($db_host,$db_user,$db_password,$db_database);

if (!$connect){
	die('Error connect to database!');
}
?>