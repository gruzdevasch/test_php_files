<?php

// Соединяемся, выбираем базу данных
$db_host = "localhost";
$db_user = "test"; // Логин БД
$db_password = "qwerty123"; // Пароль БД
$db_base = 'test'; // Имя БД
// Подключение к базе данных
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_base);
$mysqli->set_charset("utf8");
if ($mysqli->connect_errno) {
      die("Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
?>

