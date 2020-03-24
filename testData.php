<?php

include "config.php";
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0;");
if (!$mysqli->query("DROP TABLE IF EXISTS Directories") ||
        !$mysqli->query("CREATE TABLE Directories (
     id MEDIUMINT NOT NULL AUTO_INCREMENT,
     name CHAR(30) NOT NULL,
     creation_date DATETIME NOT NULL,
     modification_date DATETIME NOT NULL,
     description TEXT(255),
     parent_id MEDIUMINT,     
     FOREIGN KEY (parent_id) REFERENCES Directories (id) ON DELETE CASCADE ON UPDATE CASCADE,
     PRIMARY KEY (id)
) DEFAULT CHARSET=UTF8;") ||
        !$mysqli->query("INSERT INTO Directories(name, creation_date, modification_date, description, parent_id) "
                . "VALUES ('dir1', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'main directory', NULL), "
                . "('dir2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'second directory', NULL), "
                . "('dir3', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'inside directory', 1);")) {
    echo "Не удалось создать таблицу: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$mysqli->query("DROP TABLE IF EXISTS Elements") ||
        !$mysqli->query("CREATE TABLE Elements (
     id MEDIUMINT NOT NULL AUTO_INCREMENT,
     directory_id MEDIUMINT,     
     name CHAR(30) NOT NULL,
     creation_date DATETIME NOT NULL,
     modification_date DATETIME NOT NULL,
     type ENUM('News', 'Article', 'Review', 'Comment') NOT NULL,
     data TEXT(255),
     FOREIGN KEY (directory_id) REFERENCES Directories (id) ON DELETE CASCADE ON UPDATE CASCADE,
     PRIMARY KEY (id)
) DEFAULT CHARSET=UTF8;") ||
        !$mysqli->query("INSERT INTO Elements(directory_id, name, creation_date, modification_date, type, data) "
                . "VALUES (NULL, 'el1', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'News', 'lorum epsum'), "
                . "(1, 'el2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'Article', 'test'), "
                . "(2, 'el3', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'Review', 'test'), "
                . "(3, 'el4', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'Comment', 'Element 4 content'), "
                . "(1, 'el5', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', 'Comment', 'Element 5 content');")) {
    echo "Не удалось создать таблицу: (" . $mysqli->errno . ") " . $mysqli->error;
}

$mysqli->query("SET FOREIGN_KEY_CHECKS = 1;");
echo "Таблицы с тестовыми данными созданы!";
mysqli_close($mysqli);