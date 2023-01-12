<?php

class Queries
{
    public function createDatabase($dbname)
    {
        $sql =
            "CREATE DATABASE IF NOT EXISTS " . $dbname . ";";
        return $sql;
    }
    public function createTables()
    {
        $sql =
            "CREATE TABLE IF NOT EXISTS products (
            SKU varchar(255) PRIMARY KEY,
            name varchar(255) NOT NULL,
            price double NOT NULL,
            type varchar(255) NOT NULL
            )  ENGINE=INNODB; " .
            "CREATE TABLE IF NOT EXISTS furniture (
            id int AUTO_INCREMENT PRIMARY KEY,
            SKU varchar(255) UNIQUE NOT NULL,
            length double NOT NULL,
            width double NOT NULL,
            height double NOT NULL,
            CONSTRAINT furniture_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
            ) ENGINE=INNODB; " .
            "CREATE TABLE IF NOT EXISTS books (
            id int AUTO_INCREMENT PRIMARY KEY,
            SKU varchar(255) UNIQUE NOT NULL,
            weight double NOT NULL,
            CONSTRAINT books_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
            ) ENGINE=INNODB; " .
            "CREATE TABLE IF NOT EXISTS dvds (
            id int AUTO_INCREMENT PRIMARY KEY,
            SKU varchar(255) UNIQUE NOT NULL,
            size double NOT NULL,
            CONSTRAINT dvds_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
            ) ENGINE=INNODB; ";
        return $sql;
    }
    public function get()
    {
        $sql =
            "SELECT P.SKU, P.name, P.price, P.type, B.weight, D.size, F.height, F.width, F.length FROM products P
                LEFT JOIN books B on B.SKU = P.SKU
                LEFT JOIN dvds D on D.SKU = P.SKU
                LEFT JOIN furniture F on F.SKU = P.SKU
                ORDER BY P.SKU";
        return $sql;
    }

    public function delete()
    {
        $sql = "DELETE FROM products WHERE SKU = :id";
        return $sql;
    }

    public function add($type)
    {
        switch ($type) {
            case 'book':
                $sqlType = $this->addBook();
                break;
            case 'dvd':
                $sqlType = $this->addDVD();
                break;
            case 'furniture':
                $sqlType = $this->addFurniture();
                break;
            default:
                break;
        }
        $sql =
            "INSERT INTO products(SKU, name, price, type) VALUES(:SKU, :name, :price, :type); " . $sqlType;
        return $sql;
    }

    public function addBook()
    {
        $sql = "INSERT INTO books(SKU, weight) VALUES(:SKU, :weight)";
        return $sql;
    }
    public function addDVD()
    {
        $sql = "INSERT INTO dvds(SKU, size) VALUES(:SKU, :size)";
        return $sql;
    }
    public function addFurniture()
    {
        $sql = "INSERT INTO furniture(SKU, length, width, height) VALUES(:SKU, :length, :width, :height)";
        return $sql;
    }
}
?>