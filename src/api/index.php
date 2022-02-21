<?php
require "./config/init.php";

use App\Config\Database;
use App\Controllers\ProductController;

$url = explode('/', $_GET['url']);

// all of the endpoints start with /product
// everything else results in a 404 Not Found
if ($url[0] !== "product") {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$db = new Database();
$dbConnection = $db->connect();

// pass the request method to the ProductController and process the HTTP request:
$controller = new ProductController($dbConnection, $requestMethod);
$controller->processRequest();
