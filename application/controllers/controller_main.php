<?php

class Controller_Main extends Controller {

    function __construct() {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index($folder = 0) {
        $data = $this->model->get_data($folder);
        $this->view->generate('main_view.php', 'template_view.php', $data, 'Главная');
    }

    function action_folder($folder = 0) {
        $data = $this->model->get_data($folder);
        $this->view->generate('main_view.php', 'template_view.php', $data, 'Раздел');
    }

    function action_addFolder($folder = 0) {
        $data = Array();
        $back_url = '/';
        $parent = null;
        if (!empty($folder)) {
            if (is_numeric($folder) && $folder != 0) {
                $parent = $folder;
                if ($parent)
                    $back_url = "/folder/" . $parent;
            }
        }
        $data = Array('parent' => $parent, 'back_url' => $back_url);
        $this->view->generate('addFolder_view.php', 'template_view.php', $data, 'Создание раздела');
    }

    function action_createFolder() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->create_folder();
            $this->view->generate('addFolder_view.php', 'template_view.php', $data, 'Создание раздела');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
    
    
    function action_changeFolder($id = 0) {
        $data = $this->model->get_folder_data($id);
        $this->view->generate('changeFolder_view.php', 'template_view.php', $data, 'Изменение раздела');
    }

    function action_alterFolder() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->change_folder();
            $this->view->generate('changeFolder_view.php', 'template_view.php', $data, 'Изменение раздела');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }

    function action_addElement($folder = 0) {
        $data = Array();
        $back_url = '/';
        $parent = null;
        if (!empty($folder)) {
            if (is_numeric($folder) && $folder != 0) {
                $parent = $folder;
                if ($parent)
                    $back_url = "/folder/" . $parent;
            }
        }
        $data = Array('parent' => $parent, 'back_url' => $back_url);
        $this->view->generate('addElement_view.php', 'template_view.php', $data, 'Создание элемента');
    }

    function action_createElement() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->create_element();
            $this->view->generate('addElement_view.php', 'template_view.php', $data, 'Создание элемента');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
    
    function action_changeElement($id = 0) {
        $data = $this->model->get_element_data($id);
        $this->view->generate('changeElement_view.php', 'template_view.php', $data, 'Изменение элемента');
    }

    function action_alterElement() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->change_element();
            $this->view->generate('changeElement_view.php', 'template_view.php', $data, 'Изменение элемента');
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }

    function action_delete() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->model->delete_object();
        } else {
            echo 'Произошла ошибка. Попробуйте еще раз!';
        }
    }
}
