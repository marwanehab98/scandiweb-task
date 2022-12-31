<?php
// Parent class
abstract class Product
{
    abstract public function getProduct();
    abstract public function addProduct($conn, $type);
}

// Child classes
class DVD extends Product
{
    private $SKU;
    private $name;
    private $price;
    private $size;
    public function __construct($record, $post)
    {
        if ($post) {
            # code...
            $this->SKU = $record->SKU;
            $this->name = $record->name;
            $this->price = $record->price;
            $this->size = $record->size;
        } else {
            $this->SKU = $record['SKU'];
            $this->name = $record['name'];
            $this->price = $record['price'];
            $this->size = $record['size'];
        }
    }

    public function getProduct()
    {
        return get_object_vars($this);
    }

    public function addProduct($conn, $type)
    {
        foreach ($this->getProduct() as $key => $value) {
            if (is_null($value)) {
                $response = ['status' => '0', 'message' => 'Please, submit required data.'];
                $valid = false;
                break;
            }
            if (in_array($key, array('price', 'size')) && !is_numeric($value)) {
                $response = ['status' => '0', 'message' => 'Please, provide the data of indicated type.'];
                $valid = false;
                break;
            }
            $valid = true;
        }

        if ($valid) {
            $sql =
                "INSERT INTO products(SKU, name, price, type) VALUES(:SKU, :name, :price, :type)" .
                "INSERT INTO dvds(SKU, size) VALUES(:SKU, :size)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':SKU', $this->SKU);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':size', $this->size);

            try {
                $stmt->execute();
                $response = ['status' => '200', 'message' => 'Record created successfully.'];
            } catch (\Throwable $error) {
                $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
            }
        }
        echo json_encode($response);
    }
}

class Book extends Product
{
    private $SKU;
    private $name;
    private $price;
    private $weight;
    public function __construct($record, $post)
    {
        if ($post) {
            # code...
            $this->SKU = $record->SKU;
            $this->name = $record->name;
            $this->price = $record->price;
            $this->weight = $record->weight;
        } else {
            # code...
            $this->SKU = $record['SKU'];
            $this->name = $record['name'];
            $this->price = $record['price'];
            $this->weight = $record['weight'];
        }
    }

    public function getProduct()
    {
        return get_object_vars($this);
    }

    public function addProduct($conn, $type)
    {
        foreach ($this->getProduct() as $key => $value) {
            if (is_null($value)) {
                $response = ['status' => '0', 'message' => 'Please, submit required data.'];
                $valid = false;
                break;
            }
            if (in_array($key, array('price', 'weight')) && !is_numeric($value)) {
                $response = ['status' => '0', 'message' => 'Please, provide the data of indicated type.'];
                $valid = false;
                break;
            }
            $valid = true;
        }
        if ($valid) {
            $sql =
                "INSERT INTO products(SKU, name, price, type) VALUES(:SKU, :name, :price, :type);" .
                "INSERT INTO books(SKU, weight) VALUES(:SKU, :weight)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':SKU', $this->SKU);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':weight', $this->weight);

            try {
                $stmt->execute();
                $response = ['status' => '200', 'message' => 'Record created successfully.'];
            } catch (\Throwable $error) {
                $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
            }
        }
        echo json_encode($response);
    }
}

class Furniture extends Product
{
    private $SKU;
    private $name;
    private $price;
    private $length;
    private $width;
    private $height;
    public function __construct($record, $post)
    {
        if ($post) {
            # code...
            $this->SKU = $record->SKU;
            $this->name = $record->name;
            $this->price = $record->price;
            $this->length = $record->length;
            $this->width = $record->width;
            $this->height = $record->height;
        } else {
            # code...
            $this->SKU = $record['SKU'];
            $this->name = $record['name'];
            $this->price = $record['price'];
            $this->length = $record['length'];
            $this->width = $record['width'];
            $this->height = $record['height'];
        }
    }

    public function getProduct()
    {
        return get_object_vars($this);
    }

    public function addProduct($conn, $type)
    {
        foreach ($this->getProduct() as $key => $value) {
            if (is_null($value)) {
                $response = ['status' => '0', 'message' => 'Please, submit required data.'];
                $valid = false;
                break;
            }
            if (in_array($key, array('price', 'length', 'width', 'height')) && !is_numeric($value)) {
                $response = ['status' => '0', 'message' => 'Please, provide the data of indicated type.'];
                $valid = false;
                break;
            }
            $valid = true;
        }

        if ($valid) {
            $sql =
                "INSERT INTO products(SKU, name, price, type) VALUES(:SKU, :name, :price, :type)" .
                "INSERT INTO furniture(SKU, length, width, height) VALUES(:SKU, :length, :width, :height)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':SKU', $this->SKU);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':length', $this->length);
            $stmt->bindParam(':width', $this->width);
            $stmt->bindParam(':height', $this->height);

            try {
                $stmt->execute();
                $response = ['status' => '200', 'message' => 'Record created successfully.'];
            } catch (\Throwable $error) {
                $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
            }
        }
        echo json_encode($response);
    }
}

class ProductList
{
    private $products = array();

    public function addProduct($product)
    {
        array_push($this->products, $product->getProduct());
    }

    public function getProducts($conn)
    {
        $sql = "SELECT P.SKU, P.name, P.price, P.type, B.weight, D.size, F.height, F.width, F.length FROM products P
        LEFT JOIN books B on B.SKU = P.SKU
        LEFT JOIN dvds D on D.SKU = P.SKU
        LEFT JOIN furniture F on F.SKU = P.SKU
        ORDER BY p.SKU";
        $path = explode('/', $_SERVER['REQUEST_URI']);
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute();
            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $type = $product['type'];
                $class = $type;
                $product_object = new $class($product, false);
                $this->addProduct($product_object);
            }
            echo json_encode($this->products);
        } catch (\Throwable $error) {
            $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
            echo json_encode($response);
        }
    }

    public function deleteProduct($conn)
    {
        $sql = "DELETE FROM products WHERE SKU = :id";
        $path = explode('/', $_SERVER['REQUEST_URI']);
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $path[4]);
        try {
            $stmt->execute();
            $response = ['status' => '200', 'message' => 'Record deleted successfully.'];
        } catch (\Throwable $error) {
            $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
        }
        echo json_encode($response);
    }
}
?>