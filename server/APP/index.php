<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

require('../autoload.php');

$controller = new View;
$controller->check();