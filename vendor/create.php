<?php

require_once '../config/connect.php';

$departament = $_POST['departament'];
$category = $_POST['category'];
$inventory = $_POST['inventory'];
$title = $_POST['title'];

mysqli_query($connect,"INSERT INTO `technic` (`id`, `departament`, `category`, `inventory`, `title`) VALUES (NULL, '$departament', '$category', '$inventory', '$title')");

header('Location: ../index.php');