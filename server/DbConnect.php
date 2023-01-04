<?php
/**
 * Database Connection
 */
class DbConnect
{

	private $server = $_SERVER["SERVER"];
	private $dbname = $_SERVER["DBNAME"];
	private $user = $_SERVER["USER"];
	private $pass = $_SERVER["PASSWORD"];



	public function __construct()
	{
		$sql =
			"CREATE DATABASE IF NOT EXISTS " . $this->dbname . ";";
		$conn = new mysqli($this->server, $this->user, $this->pass);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		if ($conn->query($sql) !== TRUE) {
			echo "Error creating database: " . $conn->error;
		}
		$conn->close();
	}

	public function connect()
	{
		try {
			$conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
			$stmt = $conn->prepare($sql);
			try {
				$stmt->execute();
			} catch (\Throwable $error) {
				echo "Failed to create tables: " . $error->getMessage();
			}
			return $conn;
		} catch (\Exception $e) {
			echo "Database Error: " . $e->getMessage();
		}
	}

}
?>