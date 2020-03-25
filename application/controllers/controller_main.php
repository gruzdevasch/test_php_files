<?php

class Controller_Main extends Controller {

    function __construct() {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index($directory = 0) {
        $data = $this->model->getObjects($directory);
        $this->view->generate('main_view.php', 'template_view.php', $data, 'Главная');
    }

    function action_directory($directory = 0) {
        $data = $this->model->getObjects($directory);
        $this->view->generate('main_view.php', 'template_view.php', $data, 'Раздел');
    }

    function action_addDirectory($directory = 0) {
        $data = Array();
        $back_url = '/';
        $parent = null;
        if (!empty($directory)) {
            if (is_numeric($directory) && $directory != 0) {
                $parent = $directory;
                if ($parent)
                    $back_url = "/directory/" . $parent;
            }
        }
        $data = Array('parent' => $parent, 'back_url' => $back_url);
        $this->view->generate('addDirectory_view.php', 'template_view.php', $data, 'Создание раздела');
    }

    function action_createDirectory() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->createDirectory();
            $this->view->generate('addDirectory_view.php', 'template_view.php', $data, 'Создание раздела');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
    
    
    function action_changeDirectory($id = 0) {
        $data = $this->model->getDirectoryData($id);
        $this->view->generate('changeDirectory_view.php', 'template_view.php', $data, 'Изменение раздела');
    }

    function action_alterDirectory() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->changeDirectory();
            $this->view->generate('changeDirectory_view.php', 'template_view.php', $data, 'Изменение раздела');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }

    function action_addElement($directory = 0) {
        $data = Array();
        $back_url = '/';
        $parent = null;
        if (!empty($directory)) {
            if (is_numeric($directory) && $directory != 0) {
                $parent = $directory;
                if ($parent)
                    $back_url = "/directory/" . $parent;
            }
        }
        $data = Array('parent' => $parent, 'back_url' => $back_url);
        $this->view->generate('addElement_view.php', 'template_view.php', $data, 'Создание элемента');
    }

    function action_createElement() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->createElement();
            $this->view->generate('addElement_view.php', 'template_view.php', $data, 'Создание элемента');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
    
    function action_changeElement($id = 0) {
        $data = $this->model->getElementData($id);
        $this->view->generate('changeElement_view.php', 'template_view.php', $data, 'Изменение элемента');
    }

    function action_alterElement() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->changeElement();
            $this->view->generate('changeElement_view.php', 'template_view.php', $data, 'Изменение элемента');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }

    function action_delete() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->deleteObject();
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
}
