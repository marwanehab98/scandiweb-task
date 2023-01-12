<?php

class furniture extends Product
{
    private $length;
    private $width;
    private $height;

    function __construct($record)
    {
        parent::__construct($record);
        $this->length = $record->length;
        $this->width = $record->width;
        $this->height = $record->height;
    }
    public function getProduct()
    {
        return array_merge(parent::getProduct(), get_object_vars($this));
    }

    public function addProduct($db)
    {
        $attributes = parent::getProduct();
        $sql = (new Queries)->add($attributes['type']);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':SKU', $attributes['SKU']);
        $stmt->bindParam(':name', $attributes['name']);
        $stmt->bindParam(':price', $attributes['price']);
        $stmt->bindParam(':type', $attributes['type']);
        $stmt->bindParam(':length', $this->length);
        $stmt->bindParam(':width', $this->width);
        $stmt->bindParam(':height', $this->height);
        $stmt->execute();
    }
    public function validateAttributes()
    {
        if (!is_numeric($this->length)) {
            return ['status' => false, 'message' => 'Length has to be a number'];
        }
        if (!is_numeric($this->width)) {
            return ['status' => false, 'message' => 'Width has to be a number'];
        }
        if (!is_numeric($this->height)) {
            return ['status' => false, 'message' => 'Height has to be a number'];
        }
        return ['status' => true, 'message' => 'Valid Inputs'];
    }
}