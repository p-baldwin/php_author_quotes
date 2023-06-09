<?php
/*  The Database class encapsulates all of the details and information to 
    create, instantiate, and return a database connection object. It collects 
    the secret variables from the environment, creates a connection to the named 
    database, and returns the connection. If connection fails, the object 
    reports the failure.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    class Database {
        // DB Parameters
        private $host;
        private $port;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        // DB Connection Function
        public function connect() {
            $this->conn = null;

            // Get the DB host, name, and credentials from the environment
            $this->host = getenv('HTTP_DBHOST');
            $this->port = getenv('HTTP_DBPORT');
            $this->db_name = getenv('HTTP_DBNAME');
            $this->username = getenv('HTTP_DBUSER');
            $this->password = getenv('HTTP_DBPASSWORD');

            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            try {
                // Create the DB Connection
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection Error: {$e->getMessage()}";
            }

            // Return the DB Connection
            return $this->conn;
        }
    }