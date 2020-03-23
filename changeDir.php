<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Изменение раздела</title>
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
        $description = "";
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
            if (!empty($_POST["description"])) {
                $description = test_input(filter_input(INPUT_POST, 'description'));
            }

            if (!empty($_POST['parent_ID'])) {
                $parent = test_input(filter_input(INPUT_POST, 'parent_ID'));
            }
            if (!empty($_POST['ID'])) {
                $id = test_input(filter_input(INPUT_POST, 'ID'));
            }
            if (empty($nameErr) && !empty($id)) {
                include "config.php";
                $query = "UPDATE Directories SET name='$name', modification_date = '" . date('Y-m-d H:i:s') . "', "
                        . "description = '" . $description . "' WHERE id='$id';";

                $result = $mysqli->query($query);

                mysqli_close($mysqli);

                /* if ($result == true) {
                  echo "<script>alert('Папка успешно изменена.')</script>";
                  } else {
                  echo "<script>alert('Произошла ошибка! Попробуйте еще раз.')</script>";
                  } */
                if ($parent)
                    header('Location: /index.php?folder=' . $parent);
                else
                    header('Location: /');
                exit();
            }
        } elseif (!empty($_GET['id'])) {
            $cur_name = "";
            $cur_desc = "";
            $parent = "";
            $id = test_input(filter_input(INPUT_GET, 'id'));
            include "config.php";
            $result = $mysqli->query("SELECT * FROM Directories WHERE id = ' $id '");

            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $cur_name = $row['name'];
                $cur_desc = $row['description'];
                $parent = $row['parent_id'];
                if ($parent)
                    $back_url = "/index.php?folder=" . $parent;
            }
            mysqli_close($mysqli);
        }
        ?>
        <h2 class = "title">Изменение раздела</h2>
        <div class = "navigation">
            <a href=<?php echo $back_url ?> class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
            <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
        </div>
        <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="required_field" name="name" type="text" placeholder="Имя" <?php if (!empty($cur_name)) echo "value='$cur_name'" ?>/> 
            <span class="error"><?php if (!empty($nameErr)) echo '* ' . $nameErr; ?></span>
            <input name="description" type="text" placeholder="Описание" <?php if (!empty($cur_desc)) echo "value='$cur_desc'" ?>/>
            <input name="parent_ID"  type="hidden" value="<?php echo $parent; ?>"/>
            <input name="ID"  type="hidden" value="<?php echo $id; ?>"/>
            <input type="submit" value="Сохранить" />
        </form>
    </body>
</html>
