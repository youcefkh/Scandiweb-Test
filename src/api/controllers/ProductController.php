<?php

namespace App\Controllers;

use App\Models\Product;


class ProductController
{
    private $db;
    private $requestMethod;

    private $model;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $this->getAllProducts();
                break;
            case 'POST':
                $this->createProduct();
                break;
            case 'DELETE':
                $this->deleteProduct();
                break;
        }
    }

    /* get all products */
    private function getAllProducts()
    {
        $result = Product::findAll($this->db);
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    }

    /* create a product */
    private function createProduct()
    {
        /* get data sent by the user */
        $input = (array) json_decode(file_get_contents('php://input'), TRUE)['data'];

        /* set the model */
        $model = "App\\Models\\" . $input['type'];
        $this->model = new $model($this->db);

        if ($this->model->validateData($input) === true) {
            $result = $this->model->create($input);
            if ($result === true) {
                header("HTTP/1.1 201 Created");
                echo json_encode(array(
                    "message" => "Product created successfully"
                ));
            } else {
                header('HTTP/1.1 200 OK');
                echo json_encode(array(
                    "error" => $result
                ));
            }
        } else {
            header('HTTP/1.1 200 OK');
            echo json_encode(array(
                "error" => $this->model->validateData($input)
            ));
        }
    }

    /* mass delete products */
    private function deleteProduct()
    {
        /* get product ids sent by the user */
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        print_r($input);
        $ids = $input["ids"];
        $result = Product::delete($this->db, $ids);
        if($result === true){
            header("HTTP/1.1 200 OK");
            echo json_encode(array(
                "message" => "Products deleted successfully"
            ));
        }else{
            header('HTTP/1.1 422 Unprocessable Entity');
            echo json_encode(array(
                "error" => "Oops, something went wrong"
            ));
        }
    }
}
