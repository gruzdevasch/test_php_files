<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Создание элемента</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">  
    </head>
    <body>
        <?php

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $nameErr = "";
        $parent = "NULL";
        $back_url = "/";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["name"])) {
                $nameErr = "Название элемента - обязательное поле";
            } else {
                $name = test_input(filter_input(INPUT_POST, 'name'));
                if (!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_]+)$/u', $name)) {
                    $nameErr = "В имени допустимы только буквы и цифры";
                }
            }
// Переменные с формы
            if (empty($_POST["data"])) {
                $data = "";
            } else {
                $data = test_input(filter_input(INPUT_POST, 'data'));
            }
            if (empty($_POST["type"])) {
                $type = "";
            } else {
                $type = test_input(filter_input(INPUT_POST, 'type'));
            }

            if (!empty($_POST['folder_ID'])) {
                $parent = test_input(filter_input(INPUT_POST, 'folder_ID'));
            }
            if (empty($nameErr)) {
                include "config.php";

                $result = $mysqli->query("INSERT INTO Elements(directory_id, name, creation_date, modification_date, type, data) "
                        . "VALUES ($parent, '$name', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '$type', '$data');");

                mysqli_close($mysqli);
                /* if ($result == true) {
                  echo "<script>alert('Элемент успешно создан.')</script>";
                  } else {
                  echo "<script>alert('Произошла ошибка! Попробуйте еще раз.')</script>";
                  } */
                if ($parent)
                    header('Location: /index.php?folder=' . $parent);
                else
                    header('Location: /');
                exit();
            }
        } elseif (!empty($_GET['folder'])) {
            $folder = test_input(filter_input(INPUT_GET, 'folder'));
            if (is_numeric($folder) && $folder != 0) {
                $parent = $folder;
                if ($parent)
                    $back_url = "/index.php?folder=" . $parent;
            }
        }
        ?>
        <h2 class = "title">Создание элемента</h2>
        <div class = "navigation">
            <a href=<?php echo $back_url ?> class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
            <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
        </div>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="required_field" name="name" type="text" placeholder="Имя"/> <div class="error"><?php if (!empty($nameErr)) echo '* ' . $nameErr; ?></div>
            <span>Тип: </span><select name="type" id="type">
                <option value="News" selected="selected">Новость</option>
                <option value="Article">Статья</option>
                <option value="Review">Обзор</option>
                <option value="Comment">Комментарий</option>
            </select>
            <textarea name="data" type="text" placeholder="Содержимое"></textarea>
            <input name="folder_ID"  type="hidden" value="<?php echo $parent; ?>"/>
            <input type="submit" value="Создать" />
        </form>
    </body>
</html>
