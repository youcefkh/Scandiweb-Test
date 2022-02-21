<?php

namespace App\Models;

class DVD extends Product
{
    private $db;

    private $size;

    public function __construct($db)
    {
        $this->db = $db;
        $this->type = "DVD";
        $this->attribute = "Size";
    }

    public function create($input)
    {
        $this->setProperties($input);

        /* check if sku value is unique */
        $query = "SELECT * FROM products WHERE sku = :sku LIMIT 1";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                ':sku' => $this->sku,
            ));

            if($stmt->rowCount() > 0){
                return "SKU already exists";
            }

        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        /* insert the product */
        $query = "INSERT INTO
                    products (sku, name, price, type)
                VALUES
                    (:sku, :name, :price, :type)
                ";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                ':sku' => $this->sku,
                ':name' => $this->name,
                ':price' => $this->price,
                ':type' => $this->type,
            ));
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        /* insert the product's custom attribute and its value */
        /* get the product's id */
        $query = "SELECT LAST_INSERT_ID()";
        $this->id = $this->db->query($query)->fetch()[0];
        
        $query = "INSERT INTO
                    custom_attributes (product_id, attribute, value)
                VALUES
                    (:product_id, :attribute, :value)
                ";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(
                ':product_id' => $this->id,
                ':attribute' => $this->attribute,
                ':value' => $this->size,
            ));
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /* validate the data sent by the user */
    public function validateData($data)
    {
        if (!$data['sku'] || !$data['name'] || !$data['price'] || !$data['size']) {
            return "Please, submit required data";
        } elseif (
            !ctype_alnum($data['sku']) ||
            !preg_match('~^[\p{L}\p{N}\s]+$~uD', $data['name']) ||
            !is_numeric($data['price']) ||
            !is_numeric($data['size'])
        ) {
            return "Please, provide the data of indicated type";
        }else{
            return true;
        }
    }

    /* set properties */
    private function setProperties($data)
    {
        $this->sku = filter_var($data['sku'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->name = filter_var($data['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->price = filter_var($data['price'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->size = filter_var($data['size'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}
