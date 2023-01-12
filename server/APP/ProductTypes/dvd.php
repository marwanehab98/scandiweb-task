<?php

class dvd extends Product
{
    private $size;

    function __construct($record)
    {
        parent::__construct($record);
        $this->size = $record->size;
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
        $stmt->bindParam(':size', $this->size);
        $stmt->execute();
    }
    public function validateAttributes()
    {
        if (!is_numeric($this->size)) {
            return ['status' => false, 'message' => 'Size has to be a number'];
        }
        return ['status' => true, 'message' => 'Valid Inputs'];
    }
}
;