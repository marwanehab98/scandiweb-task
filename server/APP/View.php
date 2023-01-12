<?php

class View
{
    private $controller;

    function __construct()
    {
        $this->controller = new Controller;
    }
    private function get(): void
    {
        echo json_encode($this->controller->getProducts());
    }

    private function delete()
    {
        echo json_encode($this->controller->deleteProduct());
    }

    private function add()
    {
        echo json_encode($this->controller->addProduct());
    }

    private function post(): void
    {
        $path = explode('/', $_SERVER['REQUEST_URI']);
        switch (end($path)) {
            case 'delete':
                $this->delete();
                break;
            case 'add':
                $this->add();
                break;
            default:
                break;
        }
    }

    public function check()
    {

        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case "GET":
                $this->get();
                break;
            case "POST":
                $this->post();
                break;
        }
    }
}
;