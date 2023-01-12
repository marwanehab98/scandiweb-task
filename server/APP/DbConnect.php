<?php

class DbConnect
{
    private $server = 'localhost';
    private $dbname = 'scandiweb';
    private $user = 'root';
    private $pass = 'password';
    private $connection;

    function __construct()
    {
        $sql = (new Queries)->createDatabase($this->dbname);
        $conn = new mysqli($this->server, $this->user, $this->pass);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($conn->query($sql) !== TRUE) {
            echo "Error creating database: " . $conn->error;
        }
        $conn->close();
        $this->connection = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get()
    {
        $sql = (new Queries)->createTables();
        $stmt = $this->connection->prepare($sql);
        try {
            $stmt->execute();
            $response = $this->connection;
        } catch (\Throwable $error) {
            $response = ['status' => $error->getCode(), 'message' => $error->getMessage()];
        }
        return $response;
    }
}
;