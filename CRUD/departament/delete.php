<?php
    session_start();
    require_once '../../config/connect.php';
    $id = $_GET['id'];
    $technic = mysqli_query($connect,"DELETE FROM `departament` WHERE `departament`.`id_departament` = $id");
    if(!$technic){
        $_SESSION['deparDel'] = "Невозможно удалить, так как существуют запись в основной таблице с таким отделом.";
    }
    header('Location: ../../admin.php');
?>