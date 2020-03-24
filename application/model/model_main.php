<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

class Model_Main extends Model {

    public function get_data($folder_id = null) {
        include "config.php";
        $root = "/";
        $back_url = $root;
        $folder = null;
        if (!empty($folder_id)) {
            $folder = $folder_id;
            if (is_numeric($folder)) {
                $res = $mysqli->query("SELECT id, parent_id FROM Directories where id = " . $folder . "");
                $res->data_seek(0);
                $total = 0;
                while ($row = $res->fetch_assoc()) {
                    if ($row['parent_id'])
                        $back_url = "//{$_SERVER['HTTP_HOST']}{$root}folder/" . $row['parent_id'];

                    $total++;
                }
                if (!$total)
                    $folder = 0;
                mysqli_free_result($res);
            } else
                $folder = 0;
        }
        if ($folder)
            $res = $mysqli->query("SELECT * FROM Directories WHERE parent_id = " . $folder . " ORDER BY id ASC");
        else
            $res = $mysqli->query("SELECT * FROM Directories WHERE parent_id is NULL ORDER BY id ASC");

// Папки
        $items = Array();
        $folders = Array();
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            $url = "//{$_SERVER['HTTP_HOST']}{$root}folder/" . $row['id'];
            $escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            $row['url'] = $escaped_url;
            $folders[] = $row;
        }
        if ($folder)
            $res2 = $mysqli->query("SELECT * FROM Elements WHERE directory_id = " . $folder . " ORDER BY id ASC");
        else
            $res2 = $mysqli->query("SELECT * FROM Elements WHERE directory_id is NULL ORDER BY id ASC");
// Элементы
        $res2->data_seek(0);
        while ($row = $res2->fetch_assoc()) {
            $items[] = $row;
        }
        // Освобождаем память от результата
        mysqli_free_result($res);
        mysqli_free_result($res2);

// Закрываем соединение
        mysqli_close($mysqli);
        return array(
            'back_url' => $back_url,
            'folder' => $folder,
            'items' => $items,
            'folders' => $folders
        );
    }

    public function create_element($parent_id = null) {
        $nameErr = "";
        $parent = "NULL";
        $back_url = "/";
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

            if ($parent != 'NULL')
                header('Location: /folder/' . $parent);
            else
                header('Location: /');
            exit();
        } else {
            $data = Array();
            $back_url = '/';
            if (!empty($parent)) {
                if (is_numeric($parent) && $parent != 0) {
                    $back_url = "/folder/" . $parent;
                }
            }
            $data = Array('parent' => $parent, 'back_url' => $back_url, 'err' => $nameErr);
            return $data;
        }
    }

    public function create_folder() {

        $nameErr = "";
        $parent = "NULL";
        $back_url = "/";
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
            if ($parent != 'NULL')
                header('Location: /folder/' . $parent);
            else
                header('Location: /');
            exit();
        } else {
            $data = Array();
            $back_url = '/';
            if (!empty($parent)) {
                if (is_numeric($parent) && $parent != 0) {
                    $back_url = "/folder/" . $parent;
                }
            }
            $data = Array('parent' => $parent, 'back_url' => $back_url, 'err' => $nameErr);
            return $data;
        }
    }

    public function get_element_data($id) {
        $data = Array();
        $parent = "";
        $id = (int) test_input($id);
        include "config.php";
        $result = $mysqli->query("SELECT * FROM Elements WHERE id = ' $id '");

        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $data['id'] = $id;
            $data['cur_name'] = $row['name'];
            $data['cur_data'] = $row['data'];
            $data['cur_type'] = $row['type'];
            $parent = $row['directory_id'];
            $data['parent'] = $parent;
            if ($parent)
                $data['back_url'] = "/folder/" . $parent;
            else
                $data['back_url'] = "/";
        }
        mysqli_close($mysqli);
        return $data;
    }

    public function get_folder_data($id) {
        $data = Array();
        $parent = "";
        $id = (int) test_input($id);
        include "config.php";
        $result = $mysqli->query("SELECT * FROM Directories WHERE id = ' $id '");

        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $data['id'] = $id;
            $data['cur_name'] = $row['name'];
            $data['cur_desc'] = $row['description'];
            $parent = $row['parent_id'];
            $data['parent'] = $parent;
            if ($parent)
                $data['back_url'] = "/folder/" . $parent;
            else
                $data['back_url'] = "/";
        }
        mysqli_close($mysqli);
        return $data;
    }

    public function change_element($id = null) {
        $nameErr = "";
        $id = "";
        $content = "";
        $name = "";
        $type = "News";
        $parent = "NULL";
        $back_url = "/";
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
            $content = "";
        } else {
            $content = test_input(filter_input(INPUT_POST, 'data'));
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
                    . "data = '" . $content . "',  type = '$type' WHERE id='$id';";

            $result = $mysqli->query($query);


            mysqli_close($mysqli);

            if ($parent)
                header('Location: /folder/' . $parent);
            else
                header('Location: /');
            exit();
        } else {
            if (!empty($parent)) {
                if (is_numeric($parent) && $parent != 0) {
                    $back_url = "/folder/" . $parent;
                }
            }
            $data = Array('parent' => $parent, 'back_url' => $back_url, 'err' => $nameErr);
            $data['cur_name'] = $name;
            $data['id'] = $id;
            $data['cur_data'] = $content;
            $data['cur_type'] = $type;
            return $data;
        }
    }

    public function change_folder($id = null) {
        $nameErr = "";
        $id = "";
        $description = "";
        $name = "";
        $parent = "NULL";
        $back_url = "/";
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
            $id = (int) test_input(filter_input(INPUT_POST, 'ID'));
        }
        if (empty($nameErr) && !empty($id)) {
            include "config.php";
            $query = "UPDATE Directories SET name='$name', modification_date = '" . date('Y-m-d H:i:s') . "', "
                    . "description = '" . $description . "' WHERE id='$id';";

            $result = $mysqli->query($query);

            mysqli_close($mysqli);

            if ($parent)
                header('Location: /folder/' . $parent);
            else
                header('Location: /');
            exit();
        } else {
            if (!empty($parent)) {
                if (is_numeric($parent) && $parent != 0) {
                    $back_url = "/folder/" . $parent;
                }
            }
            $data = Array('parent' => $parent, 'back_url' => $back_url, 'err' => $nameErr);
            $data['cur_name'] = $name;
            $data['id'] = $id;
            $data['cur_desc'] = $description;
            return $data;
        }
    }

    public function delete_object() {
        if (empty($_POST["type"])) {
            $type = "";
        } else {
            $type = test_input(filter_input(INPUT_POST, 'type'));
        }
// Переменные с формы
        if (empty($_POST["id"])) {
            $id = "";
        } else {
            $id = (int) test_input(filter_input(INPUT_POST, 'id'));
        }
        include "config.php";
        $result = 0;
        if (!empty($id)) {
            if ($type == "folder") {
                $result = $mysqli->query("DELETE FROM Directories WHERE id ='$id'");
            } else {
                $result = $mysqli->query("DELETE FROM Elements WHERE id='$id'");
            }
        }
        mysqli_close($mysqli);
        if ($result) {
            echo '1';
        } else {
            echo 'Ошибка при удалении.';
        }
    }

}
