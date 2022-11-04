<?php
    session_start();
    require_once '../../config/connect.php';
    $id = $_GET['id'];
    $technic = mysqli_query($connect,"DELETE FROM `category` WHERE `category`.`id_category` = $id");
    if(!$technic){
        $_SESSION['categDel'] = "Невозможно удалить, так как существуют запись в основной таблице с такой категорией.";
    }
    header('Location: ../../admin.php');
?>