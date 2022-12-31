<?php
/**
 * Database Connection
 */
class DbConnect
{
	private $server = 'localhost';
	private $dbname = 'scandiweb_task';
	private $user = 'root';
	private $pass = '';



	// public function __construct()
	// {
	// 	$sql =
	// 		"CREATE DATABASE IF NOT EXISTS " . $this->dbname . ";" .
	// 		"CREATE TABLE IF NOT EXISTS products (
	// 			SKU varchar(255) PRIMARY KEY,
	// 			name varchar(255),
	// 			price varchar(255),
	// 			type varchar(255)
	// 			)  ENGINE=innoDB;" .
	// 		"CREATE TABLE IF NOT EXISTS furniture (
	// 			id int AUTO_INCREMENT PRIMARY KEY,
    // 			SKU varchar(255) UNIQUE,
	// 			length varchar(255),
	// 			width varchar(255),
	// 			height varchar(255),
	// 			CONSTRAINT furniture_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
	// 			) ENGINE=innoDB;" .
	// 		"CREATE TABLE IF NOT EXISTS books (
	// 			id int AUTO_INCREMENT PRIMARY KEY,
	// 			SKU varchar(255) UNIQUE,
	// 			weight varchar(255),
	// 			CONSTRAINT books_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
	// 			) ENGINE=innoDB;" .
	// 		"CREATE TABLE IF NOT EXISTS dvds (
	// 			id int AUTO_INCREMENT PRIMARY KEY,
    // 			SKU varchar(255) UNIQUE,
	// 			size varchar(255),
	// 			CONSTRAINT dvds_products FOREIGN KEY (SKU) REFERENCES products(SKU) ON DELETE CASCADE
	// 			) ENGINE=innoDB;";
	// 	$conn = new mysqli($this->server, $this->user, $this->pass);
	// 	if ($conn->connect_error) {
	// 		die("Connection failed: " . $conn->connect_error);
	// 	}
	// 	if ($conn->query($sql) === TRUE) {
	// 		echo "Database created successfully";
	// 	} else {
	// 		echo "Error creating database: " . $conn->error;
	// 	}
	// 	$conn->close();
	// }

	public function connect()
	{
		try {
			$conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (\Exception $e) {
			echo "Database Error: " . $e->getMessage();
		}
	}

}
?>