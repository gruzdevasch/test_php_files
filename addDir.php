<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Создание раздела</title>
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
                $nameErr = "Имя раздела - обязательное поле";
            } else {
                $name = test_input(filter_input(INPUT_POST, 'name'));
                if (!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_]+)$/u', $name)) {
                    $nameErr = "В имени допустимы только буквы и цифры";
                }
            }
// Переменные с формы
            if (empty($_POST["description"])) {
                $description = "";
            } else {
                $description = test_input(filter_input(INPUT_POST, 'description'));
            }

            if (!empty($_POST['parent_ID'])) {
                $parent = test_input(filter_input(INPUT_POST, 'parent_ID'));
            }
            if (empty($nameErr)) {
                include "config.php";


                $result = $mysqli->query("INSERT INTO Directories(name, creation_date, modification_date, description, parent_id) "
                        . "VALUES ('$name', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '$description', $parent);");

                mysqli_close($mysqli);
                if ($parent)
                    header('Location: /folder/' . $parent);
                else
                    header('Location: /');
                exit();
            }
        } elseif (!empty($_GET['parent'])) {
            $folder = test_input(filter_input(INPUT_GET, 'parent'));
            if (is_numeric($folder) && $folder != 0) {
                $parent = $folder;
                if ($parent)
                    $back_url = "/folder/" . $parent;
            }
        }
        ?>
        <h2 class = "title">Создание раздела</h2>
        <div class = "navigation">
            <a href=<?php echo $back_url ?> class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
            <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
        </div>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="required_field" name="name" type="text" placeholder="Имя"/> <span class="error"><?php if (!empty($nameErr)) echo '* ' . $nameErr; ?></span>
            <input name="description" type="text" placeholder="Описание"></input>
            <input name="parent_ID"  type="hidden" value="<?php echo $parent; ?>"/>
            <input type="submit" value="Создать" />
        </form>
    </body>
</html>
