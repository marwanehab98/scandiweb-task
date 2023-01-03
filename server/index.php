<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
include 'product.php';


$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case "GET":
        $products_list = new ProductList();
        $products_list->getProducts($conn);
        break;
    case "POST":
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if ($path[4] == "addproduct") {
            $product = json_decode(file_get_contents('php://input'));
            $type = $product->type;
            $class = $type;
            $product_object = new $class($product, true);
            $product_object->addProduct($conn, $type);
        } else if ($path[4] == "deleteproduct") {
            $body = json_decode(file_get_contents('php://input'));
            $sku = $body->SKU;
            $products_list = new ProductList();
            $products_list->deleteProduct($conn, $sku);
        }
        break;
}