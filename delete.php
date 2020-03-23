<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["type"])) {
        $type = "";
    } else {
        $type = test_input(filter_input(INPUT_POST, 'type'));
    }
// Переменные с формы
    if (empty($_POST["id"])) {
        $id = "";
    } else {
        $id = test_input(filter_input(INPUT_POST, 'id'));
    }
    include "config.php";
    $result = 0;
    if ($type == "folder") {
        $result = $mysqli->query("DELETE FROM Directories WHERE id ='$id'");
    } else {
        $result = $mysqli->query("DELETE FROM Elements WHERE id='$id'");
    }

   /* echo json_encode([
        "status" => $result ? 1 : 0,
        "message" => $result ? "Удаление успешно." : "Произошла ошибка!"
    ]);*/
 if ($result) {
        echo '1';
    } else {
        echo 'Ошибка при удалении.';
    }
    mysqli_close($mysqli);
}
