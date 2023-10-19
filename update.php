<?php
  require_once 'config/connect.php';

  $technic_id = $_GET['id'];
  $technic = mysqli_query($connect,"SELECT `technic`.`id`, `departament`.`id_departament`, `category`.`id_category`,  `technic`.`inventory`, `technic`.`title` FROM `technic` INNER JOIN `departament` ON `technic`.`departament` = `departament`.`id_departament` INNER JOIN `category` ON `technic`.`category` = `category`.`id_category` WHERE `technic`.`id` = '$technic_id'");
  $technic = mysqli_fetch_assoc($technic);

  $errors = [];
if (isset($_POST['update'])) {
  
  $departament = $_POST['departament'];
  $category = $_POST['category'];
  $inventory = $_POST['inventory'];
  $title = $_POST['title'];
  
  $departamentLen = mb_strlen(trim($_POST['departament'])) ;
  $categoryLen = mb_strlen(trim($_POST['category'])) ;
  $inventoryLen = mb_strlen(trim($_POST['inventory'])) ;
  $titleLen = mb_strlen(trim($_POST['title'])) ;
  
  
  if ($inventoryLen < 1) {
    $errors['inventory'] = 'Введите не менее 1 символа';
  }elseif ($inventoryLen > 5) {
    $errors['inventory'] = 'Введите не более 5 символов';
  }elseif ($inventory < 1) {
    $errors['inventory'] = 'Инвентарный номер не может быть меньше 1';
  }elseif(mysqli_num_rows(mysqli_query($connect, "SELECT inventory FROM technic WHERE inventory = $inventory"))){
    $id = mysqli_query($connect,"SELECT id FROM technic WHERE inventory = $inventory");
    $id = mysqli_fetch_assoc($id);
    if($id['id'] != $technic_id){
      $errors['inventory'] = 'Такой инвентарный номер уже существует';
    }
  }
  
  if ($titleLen > 50) {
    $errors['title'] = 'Введите не болеее 50 символов';
  }elseif ($titleLen < 5) {
    $errors['title'] = 'Введите не менее 5 символов';
  }elseif ($titleLen > 0 and !preg_match('/[^0-9]/', $title)) {
    $errors['title'] = 'Поле не может состоять только из цифр';
  }elseif($titleLen > 0 and preg_match("/[А-Яа-я!@#$%^&*(:)№;?~`<>'{}()|\/<>]/iu", $title)){
    $errors['title'] = 'Поле может содержать только латинские буквы или цифры'; 
  }
  
  if (empty($errors)) {
    mysqli_query($connect,"UPDATE `technic` SET `departament` = '$departament', `category` = '$category', `inventory` = '$inventory', `title` = '$title' WHERE `id` = '$technic_id'");
    header('Location: index.php');
  }


}
?> 

<DOCTYPE html!>
<html lang="ru">
<head>
    <link href="css/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <meta charset="utf-8">
  <title>Обновить оборудование</title>
</head>
<body class="update">
    <div class="block">
        <h3>Обновить оборудование</h3>
        <link rel="stylesheet" href="css/main.css">
        <h1><img src="css/peb.png" width="177" height="123" align="middle">Промэнергобезопасность</h1>
        <ul>
            <li><a href="index.php">База данных</a></li>
        </ul>
        <form action="#" method="post">
            <input type="hidden" name="id" value="<?= $technic['id']?>">
            <p>Отдел</p>
            <select name="departament" style="width:100%; padding: 10px 5px;">
            <?php
                $departaments = mysqli_query($connect, "SELECT * FROM `departament`");
                $departaments = mysqli_fetch_all($departaments);
                foreach ($departaments as $departament) { 
                    if($technic['id_departament'] == $departament[0]){
                        echo '<option value="'.$departament[0].'" selected>'.$departament[1].'</option>';
                    } else {
                        echo '<option value="'.$departament[0].'">'.$departament[1].'</option>';
                    }
                    
                }
            ?>
            </select><br>
            <p>Категория</p>
            <select name="category" style="width: 100%; padding: 10px 5px;">
            <?php
                $categoryes = mysqli_query($connect, "SELECT * FROM `category`");
                $categoryes = mysqli_fetch_all($categoryes);
                foreach ($categoryes as $category) { 
                    if($technic['id_category'] == $category[0]){
                        echo '<option value="'.$category[0].'" selected>'.$category[1].'</option>';
                    } else {
                        echo '<option value="'.$category[0].'">'.$category[1].'</option>';
                    }
                }
            ?>
            </select><br>
            <p>Инвентарный номер</p>
            <?php if(!empty($errors['inventory']))echo $errors['inventory'];?>
            <input type="number" name="inventory" value="<?= $technic['inventory']?>"><br>
            <p>Название оборудования</p>
            <?php if(!empty($errors['title']))echo $errors['title'];?>
            <textarea name="title"><?= $technic['title']?></textarea><br><br>
            <button name="update" type="submit">Обновить оборудование</button>
        </form>
    </div>
</body>
</html>