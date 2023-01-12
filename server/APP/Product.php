<?php

abstract class Product
{
    private $SKU;
    private $name;
    private $price;
    private $type;
    public function __construct($record)
    {
        $this->SKU = $record->SKU;
        $this->name = $record->name;
        $this->price = $record->price;
        $this->type = $record->type;
    }
    public function getProduct()
    {
        return get_object_vars($this);
    }

    public function validateData()
    {
        if (strlen($this->SKU) < 1) {
            return ['status' => false, 'message' => 'Invalid SKU'];
        }
        if (strlen($this->name) < 1) {
            return ['status' => false, 'message' => 'Name can\'t be empty'];
        }
        if (!is_numeric($this->price)) {
            return ['status' => false, 'message' => 'Price has to be a number'];
        }
        if (!in_array($this->type, array("book", "dvd", "furniture"))) {
            return ['status' => false, 'message' => 'Invalid type'];
        }
        return ['status' => true, 'message' => 'Valid Inputs'];
    }
    abstract public function addProduct($db);
    abstract public function validateAttributes();
}
;