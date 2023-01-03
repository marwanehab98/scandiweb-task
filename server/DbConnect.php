<?php
/**
 * Database Connection
 */
class DbConnect
{
	// private $server = 'localhost';
	// private $dbname = 'id20087235_scandiweb_task';
	// private $user = 'id20087235_root';
	// private $pass = 'WpG)fM7WHlk%oEOX';
	
// 	private $server = 'sql7.freemysqlhosting.net';
// 	private $dbname = 'sql7587618';
// 	private $user = 'sql7587618';
// 	private $pass = '2BbPJcDg3X';

	private $server = 'localhost';
	private $dbname = 'scandiweb_task';
	private $user = 'root';
	private $pass = '';



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