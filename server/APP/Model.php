<?php

class Model
{
    public function getProducts($db)
    {
        try {
            $response = array();
            $sql = (new Queries)->get();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $type = $product['type'];
                $class = $type;
                $product_object = new $class(json_decode(json_encode($product)));
                array_push($response, $product_object->getProduct());
            }
        } catch (\Throwable $error) {
            $response = ['status' => $error->getCode(), 'message' => 'Failed to get products'];
        }
        return $response;
    }

    public function deleteProduct($db)
    {
        try {
            $body = json_decode(file_get_contents('php://input'));
            $sku = $body->SKU;
            $sql = (new Queries)->delete();
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $sku);
            $stmt->execute();
            $response = ['status' => '200', 'message' => 'Record deleted successfully.'];
        } catch (\Throwable $error) {
            $response = ['status' => $error->getCode(), 'message' => 'Failed to delete product'];
        }
        return $response;
    }

    public function addProduct($db)
    {
        try {
            $body = json_decode(file_get_contents('php://input'));
            $type = $body->type;
            $class = $type;
            $product_object = new $class($body);
            $validData = $product_object->validateData();
            if (!$validData['status']) {
                throw new Exception($validData['message'], 0);
            }
            $validAttributes = $product_object->validateAttributes();
            if (!$validAttributes['status']) {
                throw new Exception($validAttributes['message'], 0);
            }
            $product_object->addProduct($db);
            $response = ['status' => '200', 'message' => 'Product added successfully.'];
        } catch (\Throwable $error) {
            if ($error->getCode() == "23000") {
                $response = ['status' => $error->getCode(), 'message' => 'Duplicate SKU'];
            } else {
                $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
            }
        }
        return $response;
    }
}
;