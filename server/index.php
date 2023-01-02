<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Max-Age: 86400');
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
        if ($path[1] == "addproduct") {
            $product = json_decode(file_get_contents('php://input'));
            $type = $product->type;
            $class = $type;
            // echo json_encode($path);
            $product_object = new $class($product, true);
            $product_object->addProduct($conn, $type);
        } else {
            $products_list = new ProductList();
            $products_list->deleteProduct($conn, $path[2]);
        }
        break;
    // case "DELETE":
    //     $products_list = new ProductList();
    //     $products_list->deleteProduct($conn);
    //     break;
}