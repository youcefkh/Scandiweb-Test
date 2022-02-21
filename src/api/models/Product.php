<?php

namespace App\Models;

abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $attribute;


    /* get all products */
    public static function findAll($db)
    {
        $query = "SELECT 
                    p.*, ca.attribute, ca.value 
                FROM 
                    products p 
                LEFT JOIN 
                    custom_attributes ca ON p.id = ca.product_id 
                ORDER BY 
                    p.id DESC";

        try {
            $stmt = $db->query($query);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /* insert a new product into the db */
    abstract public function create($input);

    /* Mass delete */
    public static function delete($db, $ids)
    {
        foreach($ids as $id){

            $query = "DELETE FROM products WHERE id = :id";
    
            try {
                $stmt = $db->prepare($query);
                $stmt->execute([':id' => $id]);
            } catch (\PDOException $e) {
                return $e->getMessage();
            }
        }

        return true;
    }
}
