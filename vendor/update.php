<?php 

require_once '../config/connect.php';

$id = $_POST['id'];
$departament = $_POST['departament'];
$category = $_POST['category'];
$inventory = $_POST['inventory'];
$title = $_POST['title'];

mysqli_query($connect,"UPDATE `technic` SET `departament` = '$departament', `category` = '$category', `inventory` = '$inventory', `title` = '$title' WHERE `technic`.`id` = '$id'");

header('Location: ../index.php');