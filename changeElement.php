<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Изменение элемента</title>
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
        $id = "";
        $data = "";
        $type = "News";
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
            if (!empty($_POST['ID'])) {
                $id = test_input(filter_input(INPUT_POST, 'ID'));
            }
            if (empty($nameErr) && !empty($id)) {
                include "config.php";

                $query = "UPDATE Elements SET name='$name', modification_date = '" . date('Y-m-d H:i:s') . "', "
                        . "data = '" . $data . "',  type = '$type' WHERE id='$id';";

                $result = $mysqli->query($query);


                mysqli_close($mysqli);
                /*if ($result == true) {
                    echo "<script>alert('Элемент успешно создан.')</script>";
                } else {
                    echo "<script>alert('Произошла ошибка! Попробуйте еще раз.')</script>";
                }*/
                
                if ($parent)
                    header('Location: /index.php?folder=' . $parent);
                else
                    header('Location: /');
                exit();
            }
        } elseif (!empty($_GET['id'])) {
            $cur_name = "";
            $cur_data = "";
            $cur_type = "";
            $parent = "";
            $id = test_input(filter_input(INPUT_GET, 'id'));
            include "config.php";
            $result = $mysqli->query("SELECT * FROM Elements WHERE id = ' $id '");

            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $cur_name = $row['name'];
                $cur_data = $row['data'];
                $cur_type = $row['type'];
                $parent = $row['directory_id'];
                if ($parent)
                    $back_url = "/index.php?folder=" . $parent;
            }
            mysqli_close($mysqli);
        }
        ?>
        <h2 class = "title">Изменение элемента</h2>
        <div class = "navigation">
            <a href=<?php echo $back_url ?> class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
            <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
        </div>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="required_field" name="name" type="text" placeholder="Имя" <?php if (!empty($cur_name)) echo "value='$cur_name'" ?>/> <div class="error"><?php if (!empty($nameErr)) echo '* ' . $nameErr; ?></div>
            <span>Тип: </span><select name="type" id="type">
                <option value="News" <?= $cur_type == 'News' ? ' selected="selected"' : ''; ?>>Новость</option>
                <option value="Article" <?= $cur_type == 'Article' ? ' selected="selected"' : ''; ?>>Статья</option>
                <option value="Review" <?= $cur_type == 'Review' ? ' selected="selected"' : ''; ?>>Обзор</option>
                <option value="Comment" <?= $cur_type == 'Comment' ? ' selected="selected"' : ''; ?>>Комментарий</option>
            </select>
            <textarea name="data" type="text" placeholder="Содержимое" ><?php if (isset($cur_data)) echo $cur_data ?></textarea>
            <input name="folder_ID"  type="hidden" value="<?php echo $parent; ?>"/>
            <input name="ID"  type="hidden" value="<?php echo $id; ?>"/>
            <input type="submit" value="Сохранить" />
        </form>
    </body>
</html>
