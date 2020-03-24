<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Element Manager</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
        <link href="css/styles.css" rel="stylesheet" type="text/css">  
        <script src="js/script.js"></script>

    </head>
    <body>
        <?php
        include "config.php";

        $root = "/";
        $back_url = $root;
        $folder = null;
        if (!empty($_GET['folder'])) {
            $folder = urldecode($_GET['folder']);
            if (is_numeric($folder)) {
                $res = $mysqli->query("SELECT id, parent_id FROM Directories where id = " . $folder . "");
                $res->data_seek(0);
                $total = 0;
                while ($row = $res->fetch_assoc()) {
                    if ($row['parent_id'])
                        $back_url = "//{$_SERVER['HTTP_HOST']}{$root}index.php?folder=" . $row['parent_id'];

                    $total++;
                }
                if (!$total)
                    $folder = 0;
                mysqli_free_result($res);
            } else
                $folder = 0;
        }

// Заголовок и панель управления
        echo '<h2 class = "title">Файловый менеджер</h2>';
        echo '<div class = "controls">';
        echo '<a class="control-icon icon-new-folder" href="/addDir.php?parent=' . $folder . '" > <span class="tooltiptext">Добавить раздел</span></a>';
        echo '<a class="control-icon icon-new-file" href="/addElement.php?folder=' . $folder . '" ><span class="tooltiptext">Добавить элемент</span></a>';

        echo '<a href="' . $root . '" class = "control-icon icon-home"><span class="tooltiptext">В начало</span></a>';
        echo '<a href="' . $back_url . '" class = "control-icon icon-back"><span class="tooltiptext">Наверх</span></a>';
        echo '</div>';
        echo '<div class = "directory" >';

        if ($folder)
            $res = $mysqli->query("SELECT * FROM Directories WHERE parent_id = " . $folder . " ORDER BY id ASC");
        else
            $res = $mysqli->query("SELECT * FROM Directories WHERE parent_id is NULL ORDER BY id ASC");

// Выводим результаты в html
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            $url = "//{$_SERVER['HTTP_HOST']}{$root}?folder=" . $row['id'];
            $escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            echo '<a href="' . $escaped_url . '" class = "folder" id=' . $row['id'] . '>';
            echo '<div class = "icon icon-folder"></div>';
            echo " <div class = 'icon-name'> " . $row['name'] . "</div>";
            echo "<div class = 'tooltiptext'>";
            echo "Номер раздела: " . $row['id'] . "<br/>";
            if ($row['description'])
                echo "Описание раздела: " . $row['description'] . "<br/>";
            echo "Дата создания: " . date('d.m.Y H:i', strtotime($row['creation_date'])) . "<br/>";
            echo "Дата изменения: " . date('d.m.Y H:i', strtotime($row['modification_date'])) . "<br/>";
            echo '</div>';

            echo '</a>';
        }

        if ($folder)
            $res2 = $mysqli->query("SELECT * FROM Elements WHERE directory_id = " . $folder . " ORDER BY id ASC");
        else
            $res2 = $mysqli->query("SELECT * FROM Elements WHERE directory_id is NULL ORDER BY id ASC");

        $res2->data_seek(0);
        while ($row = $res2->fetch_assoc()) {
            echo '<div class = "file" id=' . $row['id'] . '>';
            echo '<div class = "icon icon-file"></div>';
            /* echo " id = " . $row['id'] . "\n"; */
            echo " <div class = 'icon-name'> " . $row['name'] . "</div>";

            echo "<div class = 'tooltiptext'>";
            echo "Дата создания: " . date('d.m.Y H:i', strtotime($row['creation_date'])) . "<br/>";
            echo "Дата изменения: " . date('d.m.Y H:i', strtotime($row['modification_date'])) . "<br/>";
            echo "Тип: " . $row['type'] . "<br/>";
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
// Освобождаем память от результата
        mysqli_free_result($res);
        mysqli_free_result($res2);

// Закрываем соединение
        mysqli_close($mysqli);
        ?>

    </body>
</html>
