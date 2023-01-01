<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
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
        $product = json_decode(file_get_contents('php://input'));
        $type = $product->type;
        $class = $type;
        $product_object = new $class($product, true);
        $product_object->addProduct($conn, $type);
        break;
    case "DELETE":
        $products_list = new ProductList();
        $products_list->deleteProduct($conn);
        break;
}