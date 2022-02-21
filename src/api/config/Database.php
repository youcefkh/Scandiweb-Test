<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "scandiweb";
    private $username = "root";
    private $password = "";
    private $connection;

    //db connect
    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connection error: " . $e->getMessage;
        }

        return $this->connection;
    }
}
