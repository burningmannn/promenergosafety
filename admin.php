<?php
session_start();
$errors = [];

if (isset($_POST['btn-in'])) {
    $user = 0;
    $login = trim($_POST["login"]);
    $loginLen = mb_strlen($login);
    $pass = trim($_POST["pass"]);
    $passLen = mb_strlen($pass);

    $r_host = "localhost";
    $r_user = "root";
    $r_password = "";
    $r_database = "register";
    $check = new mysqli($r_host, $r_user, $r_password, $r_database);
    
    if ($passLen == 0 || $loginLen == 0) {
        $errors[] = 'Заполните все поля';

    }elseif (preg_match("/[А-Яа-я!@#$%^&*(:)№;?~`<>'{}()|\/<>]/", $login)) {
        $errors[] = 'Поле логина должно содержать только латинские буквы и числа';

    }elseif ($loginLen > 20) {
        $errors[] = 'Логин не должен быть длиннее 20 символов';

    }elseif ($loginLen < 10) {
        $errors[] = 'Логин не должен быть меньше 10 символов';

    }elseif (preg_match("/[А-Яа-я!@#$%^&*(:)№;?~`<>'{}()|\/<>]/", $pass)) {
        $errors[] = 'Поле пароля должно содержать только латинские буквы и числа';

    }elseif ($passLen > 20) {
        $errors[] = 'Пароль не должен быть длиннее 20 символов';
        
    }elseif ($passLen < 10) {
        $errors[] = 'Пароль не должен быть меньше 10 символов';

    }
    
    if(empty($errors)){
      $result = mysqli_query($check, "SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
    // var_dump($result);
      $user = $result->fetch_assoc();
      if ($user == 0) {
            $errors[] = 'Такого пользователя не существует';
        }
    }

    if(empty($errors)){
        setcookie('user',$user['name'],time() + 3600, "/");
        header("Location: index.php"); 
    }

}
require_once 'config/connect.php';
if(isset($_POST['dep'])) {
    $departament = trim($_POST['departament']);
    if (empty($departament)) { 
        $errors['$departament'] = 'Заполните все поля';
    } elseif (!preg_match("/[А-Яа-я]/", $departament)) {
        $errors['$departament'] = 'Название отдела может содержать только русские буквы';
    } elseif (mb_strlen($departament) > 50) {
        $errors['$departament'] = 'Название отдела не может быть длиннее 50 символов';
    } elseif (mb_strlen($departament) < 5) {
       $errors['$departament'] = 'Название отдела не может быть меньше 5 символов';
    }
    
    if (empty($errors['$departament'])){
    $technic = mysqli_query($connect,"INSERT INTO `departament` (`id_departament`, `nameDepartament`) VALUES (NULL, '$departament')");
        if(!$technic){
            $errors['$departament'] = "Такой отдел уже существует";
        }
    }
}

if(isset($_POST['categ'])) {
    $category = trim($_POST['category']);
    if (empty($category)) { 
        $errors['category'] = 'Заполните все поля';
    }elseif (!preg_match("/[А-Яа-я]/", $category)) {
        $errors['category'] = 'Название категории должно содержать только русские буквы';
    }elseif (mb_strlen($category) > 50) {
        $errors['category'] = 'Название категории не должено быть длиннее 50 символов';
    }elseif (mb_strlen($category) < 2) {
       $errors['category'] = 'Название категории не должено быть меньше 2 символов';
    }
    
    if (empty($errors['category'])){
    $technic = mysqli_query($connect,"INSERT INTO `category` (`id_category`, `nameCategory`) VALUES (NULL, '$category')");
        if(!$technic){
            $errors['category'] = "Такая категория уже существует";
        }
    }
}
?>

<DOCTUPE HTML!>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Промэнергобезопасность</title>
        <link href="css/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="css/Design.css">
                <link rel="stylesheet" href="css/main.css">
        
    </head>
    <body>
        <h1><img src="css/peb.png" width="177" height="123" align="middle">Промэнергобезопасность</h1>
        <ul>
            <li><a href="index.php">База данных</a></li>
            <li><a href="admin.php">Администратор</a></li>
            <li><a href="back.php">Обратная связь</a></li>
        </ul>
    </body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Промэнергобезопасность</title>
    <link href="css/favicon.ico" rel="shortcut icon" type="image/x-icon">
</head>
<body class="admin">

    <?php
    if (!isset($_COOKIE['user'])) $_COOKIE['user'] = '';
    if ($_COOKIE ['user'] == 'nenuzhno'):
    ?>
    <h3>Форма регистрации</h3>
    <form action="vendor/check.php" method="post">
        <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
        <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
        <input type="text" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
        <button class="btn btn-success" type="submit">Зарегистрировать</button>
    </form>
    <?php endif; ?>

    <?php
    if (!empty($_COOKIE ['user'] == 'adminpanel')):
    ?>
        <div class="table index">
        
        <main class="wrapper-content-maint" style="min-height: 300px;margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; margin: 0 auto;">
                <div class="scroll-table" style="width: 900px; margin: 0;">
                    <?php if(!empty($errors['$departament']))echo '<p style="width:100% !important;">'.$errors['$departament'].'</p>';?>
                    <?php if(isset($_SESSION['deparDel'])){
                        echo '<span>'. $_SESSION['deparDel'].'</span>'; 
                        unset($_SESSION['deparDel']);
                    }?>
                    <form action="#" method="post" style="flex-direction: row; margin-bottom: 5px; width: 100%; justify-content: space-between;
">
                    <input name="departament" id="departament" placeholder="Введите название отдела" style=" width: 82%; margin: 0;">
                    <button class="btn btn-success" name="dep" type="submit" style=" margin-bottom: 5px; ">Добавить</button>
                </form>
                
                <table align="center">
                    <thead>
                        <tr>
                            <th style="width: 81%;">Отдел</th>
                            <th style="width: 13%; ">Опции</th>
                        </tr>
                    </thead>
                </table>
                <div class="scroll-table-body">
                    <table>
                        <tbody>
                            <?php
                                $departaments = mysqli_query($connect, "SELECT * FROM `departament` ORDER BY `departament`.`id_departament` ASC");
                                $departaments = mysqli_fetch_all($departaments);
                                foreach ($departaments as $departament) {
                                    ?>
                            <tr>
                                <td style="width: 81%;"><?= $departament[1] ?></td>
                                <td style="width: 13%; text-align:center">
                                        <a style="color: red;" href="CRUD/departament/delete.php?id=<?= $departament[0] ?>">Удалить</a>
                                        </td>
                            </tr>
                            <?php } ?>
                                                </tbody>
                </table>
                </div>
                </div>
                
                <div class="scroll-table" style=" width: 900px; margin: 0; "> 
                <?php if(!empty($errors['category']))echo '<p style="width:100% !important;">'. $errors['category'].'</p>';?>
                <?php if(isset($_SESSION['categDel'])){
                    echo '<span>'. $_SESSION['categDel'].'</span>'; 
                    unset($_SESSION['categDel']);
                }?>
                <form action="#" method="post" style="flex-direction: row; margin-bottom: 5px; width: 100%; justify-content: space-between;
">
                    <input name="category" id="category" placeholder="Введите название категории" style=" width: 82%; margin: 0;">
                    <button class="btn btn-success" name="categ" type="submit" style=" margin-bottom: 5px; ">Добавить</button>
                </form>
                <table align="center">
                    <thead>
                        <tr>
                            <th style="width:81%">Категория</th>
                            <th style="width: 13%; ">Опции</th>
                        </tr>
                    </thead>
                </table>
                <div class="scroll-table-body">
                    <table>
                        <tbody>
                             <?php
                                $categoryes = mysqli_query($connect, "SELECT * FROM `category` ORDER BY `category`.`id_category` ASC");
                                $categoryes = mysqli_fetch_all($categoryes);
                                foreach ($categoryes as $category) {
                                    ?>
                            <tr>
                                <td style="width:81%"><?= $category[1] ?></td>
                                <td style="width:13%; text-align:center">
                                        <a style="color: red;" href="CRUD/category/delete.php?id=<?= $category[0] ?>">Удалить</a>
                                        </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                </table>
                </div>
            </div>
            </div>
            
            
        
    </main></div>
    
        <p align="center">
        Чтобы выйти из режима администратора нажмите <a href="vendor/exit.php" style="color: deepskyblue;">здесь</a>.<p>
            <?php endif; ?>


            <?php
            if (!empty($_COOKIE ['user'] == '')):
            ?>
            <div class="form_block">
                <h3 style="font-size: 20px;">Форма авторизации</h3>
                <?php
                if(isset($errors[0]) ) echo $errors[0];?>
                <form action="#" method="post">
                    <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
                    <button class="btn btn-success" type="submit" name="btn-in">Авторизоваться</button>
                </form>
            </div>
            <?php endif; ?>
        </body>
    </html>