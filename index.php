<?php

require_once 'config/connect.php';
$views = json_decode(file_get_contents("views.json"));
$views->table++;
file_put_contents('views.json', json_encode($views));

/* echo 'Количество посещений: '.$views->table; */
  
if (isset($_POST['addForm'])) {
$errors = [];
  $departament = $_POST['departament'];
  $category = $_POST['category'];
  $inventory = $_POST['inventory'];
  $title = $_POST['title'];
  
  $departamentLen = mb_strlen(trim($_POST['departament'])) ;
  $categoryLen = mb_strlen(trim($_POST['category'])) ;
  $inventoryLen = mb_strlen(trim($_POST['inventory'])) ;
  $titleLen = mb_strlen(trim($_POST['title'])) ;
  /*
  if ($departamentLen > 50) {
    $errors['departament'] = 'Введите не более 50 символов';
  }elseif ($departamentLen < 5) {
    $errors['departament'] = 'Введите не менее 5 символов';
  }elseif ($departamentLen > 0 and !preg_match('/[^0-9]/', $departament)){
    $errors['departament'] = 'Поле не может состоять только из цифр';
  }elseif($departamentLen > 0 and preg_match("/[A-Za-z!@#$%^&*(:)№;?~`<>'{}()|\/<>]/iu", $departament)){
    $errors['departament'] = 'Поле может содержать только кириллицу или цифры';
  } 
  
  if ($categoryLen > 20) {
    $errors['category'] = 'Введите не более 20 символов';
  }elseif ($categoryLen < 2) {
    $errors['category'] = 'Введите не менее 2 символов';
  }elseif ($categoryLen > 0 and !preg_match('/[^0-9]/', $category)){
    $errors['category'] = 'Поле не может состоять только из цифр';
  }elseif($categoryLen > 0 and preg_match("/[A-Za-z!@#$%^&*(:)№;?~`<>'{}()|\/<>]/iu", $category)){
    $errors['category'] = 'Поле может содержать только кириллицу или цифры'; 
  }
  */
  if ($inventoryLen < 1) {
    $errors['inventory'] = 'Введите не менее 1 символа';
  }elseif ($inventoryLen > 5) {
    $errors['inventory'] = 'Введите не более 5 символов';
  }elseif ($inventory < 1) {
    $errors['inventory'] = 'Инвентарный номер не может быть меньше 1';
  }elseif(mysqli_num_rows(mysqli_query($connect, "SELECT inventory FROM technic WHERE inventory = $inventory"))){
    $errors['inventory'] = 'Такой номер уже существует';
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
     mysqli_query($connect,"INSERT INTO `technic` (`id`, `departament`, `category`, `inventory`, `title`) VALUES (NULL, '$departament', '$category', '$inventory', '$title')");
  }


}
?>

<DOCTUPE HTML!>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Промэнергобезопасность</title>
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
    <meta charset="utf-8">
    <title>Промэнергобезопасность</title>
    <link href="css/favicon.ico" rel="shortcut icon" type="image/x-icon">
</head>
<body class="index">

    <?php
    $sort_list = array(
        'id_asc' => '`id`',
        'id_desc' => '`id` DESC',
        'deportament_asc' => '`departament`.`nameDepartament`',
        'deportament_desc' => '`departament`.`nameDepartament` DESC',
        'category_asc' => '`category`.`nameCategory`',
        'category_desc' => '`category`.`nameCategory` DESC',
        'inventory_asc' => '`inventory`',
        'inventory_desc' => '`inventory` DESC',
        'title_asc' => '`title`',
        'title_desc' => '`title` DESC'
    );


    /* Проверка GET-переменной */
    $sort = @$_GET['sort'];
    if (array_key_exists($sort, $sort_list)) {
        $sort_sql = $sort_list[$sort];
    } else {
        $sort_sql = reset($sort_list);
    }
    function sort_link_bar($title, $a, $b) {
        $sort = @$_GET['sort'];

        if ($sort == $a) {
            return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>↑</i></a>';
        } elseif ($sort == $b) {
            return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>↓</i></a>';
        } else {
            return '<a href="?sort=' . $a . '">' . $title . '</a>';
        }
    }
    ?>
    <div class="table">
        <div class="sort" style="display: inline-block; text-align: center;">
            <form action="export.php" method="GET">
                <input name="sort" type="hidden" value="<?=$sort_sql ?>">
                <button name="export" type="submit">Экспорт таблицы</button>
            </form>
            <?php
            echo '<div>Сортировать таблицу по: </div>';
            echo sort_link_bar('ID', 'id_asc', 'id_desc');
            echo sort_link_bar('Отдел', 'deportament_asc', 'deportament_desc');
            echo sort_link_bar('Категория', 'category_asc', 'category_desc');
            echo sort_link_bar('Инв/номер', 'inventory_asc', 'inventory_desc');
            echo sort_link_bar('Название', 'title_asc', 'title_desc');
            if (!isset($_COOKIE['user'])) $_COOKIE['user'] = '';
            if ($_COOKIE['user'] == ''): ?>
        </div>
        <main class="wrapper-content-maint" style="min-height: 300px">
            <div class="scroll-table">
                <table align="center">
                    <thead>
                        <tr>
                            <th style="width:4%">ID</th>
                            <th style="width:35%">Отдел</th>
                            <th style="width:23%">Категория</th>
                            <th style="width:9%">Инв/номер</th>
                            <th style="width:35%">Название</th>
                        </tr>
                    </thead>
                </table>
                <div class="scroll-table-body">
                    <table>
                        <tbody>
                            <tr>
                                <?php
                                $technic = mysqli_query($connect, "SELECT `technic`.`id`, `departament`.`nameDepartament`, `category`.`nameCategory`, `technic`.`inventory`, `technic`.`title` FROM `technic` INNER JOIN `departament` ON `technic`.`departament` = `departament`.`id_departament` INNER JOIN `category` ON `technic`.`category` = `category`.`id_category` ORDER BY {$sort_sql}");
                                $technic = mysqli_fetch_all($technic);
                                foreach ($technic as $technic) {
                                    ?>
                                    <td style="width:4%"><?= $technic[0] ?></td>
                                    <td style="width:35%"><?= $technic[1] ?></td>
                                    <td style="width:23%"><?= $technic[2] ?></td>
                                    <td style="width:9%"><?= $technic[3] ?></td>
                                    <td style="width:35%" ><?= $technic[4] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else : ?>
        </div>
        <main class="wrapper-content-maint" style="min-height: 300px">
            <div class="scroll-table">
                <table align="center">
                    <thead>
                        <tr>
                            <th style="width:5%">ID</th>
                            <th style="width:41%">Отдел</th>
                            <th style="width:36%">Категория</th>
                            <th style="width:15%">Инв/номер</th>
                            <th style="width:35%">Название</th>
                            <th style="width:23%">Опции</th>
                        </tr>
                    </thead>
                </table>
                <div class="scroll-table-body">
                    <table>
                        <tbody>
                            <?php
                            $technic = mysqli_query($connect, "SELECT `technic`.`id`, `departament`.`nameDepartament`, `category`.`nameCategory`, `technic`.`inventory`, `technic`.`title` FROM `technic` INNER JOIN `departament` ON `technic`.`departament` = `departament`.`id_departament` INNER JOIN `category` ON `technic`.`category` = `category`.`id_category` ORDER BY {$sort_sql}");
                            $technic = mysqli_fetch_all($technic);
                            foreach ($technic as $technic) {
                                ?>
                                <td style="width:5%"><?= $technic[0] ?></td>
                                <td style="width:41%"><?= $technic[1] ?></td>
                                <td style="width:36%"><?= $technic[2] ?></td>
                                <td style="width:15%"><?= $technic[3] ?></td>
                                <td style="width:35%"><?= $technic[4] ?></td>
                                <td style="width:23%">
                                    <div style="display: flex; justify-content: space-around;">
                                        <a style="color: darkblue;" href="update.php?id=<?= $technic[0] ?>">Изменить</a>
                                        <a style="color: red;" href="vendor/delete.php?id=<?= $technic[0] ?>">Удалить</a>
                                        </div>
                                        </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="addTex">
        <h3>Добавить новое оборудование</h3>
        <form action="index.php" method="post">
            <?php if(!empty($errors['departament']))echo $errors['departament'];?>
            <span>Отдел</span>
            <select name="departament" style="width:100%; padding: 10px 5px;">
            <?php
                $departaments = mysqli_query($connect, "SELECT * FROM `departament`");
                $departaments = mysqli_fetch_all($departaments);
                foreach ($departaments as $departament) { 
                    echo '<option value="'.$departament[0].'">'.$departament[1].'</option>';
                }
            ?>
            </select>
            <!--<textarea name="departament" placeholder="Введите отдел"></textarea>--><br>
            <?php if(!empty($errors['category']))echo $errors['category'];?>
            <span>Категория</span>
            <select name="category" style="width: 100%; padding: 10px 5px;">
            <?php
                $categoryes = mysqli_query($connect, "SELECT * FROM `category`");
                $categoryes = mysqli_fetch_all($categoryes);
                foreach ($categoryes as $category) { 
                    echo '<option value="'.$category[0].'">'.$category[1].'</option>';
                }
            ?>
            </select>
            <!--<input type="text" name="category" placeholder="Введите категорию">--><br>
            <?php if(!empty($errors['inventory']))echo $errors['inventory'];?> 
            <input type="number" name="inventory" placeholder="Введите инвентарный номер"><br>
            <?php if(!empty($errors['title']))echo $errors['title'];?> 
            <textarea name="title" placeholder="Введите название оборудования"></textarea>
            <br>
            <button name="addForm" type="submit">Добавить оборудование</button>
        </form>
        </div>
    </div>
    <?php endif; ?>

    <hr>
</main>
<footer align="center">
    &copy; 2022 ООО "Промэнергобезопасность". Проведение экспертизы промышленной безопасности. Все права защищены. Копирование материалов сайта запрещено.<br>Адрес: г. Екатеринбург, ул. Чебышева, д. 4, оф. 416/1. Тел./факс: +7 (343) 357 53 20. Почта: info@peb2011.ru
</footer>
<script src="//cdn.jsdelivr.net/npm/eruda"></script> <script>eruda.init();</script>

</body>
</html>