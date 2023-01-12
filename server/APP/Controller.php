<?php

class Controller
{
    private $db;
    private $products = array();
    private $model;

    function __construct()
    {
        $this->db = (new DbConnect)->get();
        $this->model = new Model;
    }
    public function getProducts()
    {
        $this->products = $this->model->getProducts($this->db);
        return $this->products;
    }

    public function deleteProduct()
    {
        $response = $this->model->deleteProduct($this->db);
        return $response;
    }
    public function addProduct()
    {
        $response = $this->model->addProduct($this->db);
        return $response;
    }
}
;