<?php
// Categories Class
    class Category {
        // DB Connection Properties
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $category;

        // Post Class Constructor. Expects a DB Connection in $db.
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            // Create Select Query
            $query = "SELECT
                            id,
                            category
                        FROM
                            {$this->table}
                        ORDER BY
                            id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            // Return results of executing Query
            return $stmt;
        }

            // Get Single Category
            public function read_single() {
                // Create Select Query
                $query = "SELECT 
                                id,
                                category
                            FROM 
                                {$this->table}
                            WHERE 
                                id = :id";
    
                // Prepare Statement
                $stmt = $this->conn->prepare($query);
    
                // Bind Parameter to Query
                $stmt->bindParam(':id', $this->id);
    
                // Execute Query
                $stmt->execute();
    
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Set Properties
                $this->id = $row['id'];
                $this->category = $row['category'];
    
                // Return results of executing Query
                return $stmt;
            }

        // Create New Category
        public function create() {
            // Create Insert Query
            $query = "INSERT INTO 
                            {$this->table}
                            (category)
                        VALUES 
                            (:category)";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Parameters
            $stmt->bindParam(':category', $this->category);

            // Execute Query
            if($stmt->execute()) {
                // Return true on success
                return true;
            } else {
                // Return false and print error on failure
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        // Update Existing Category
        public function update() {
            // Create Update Query
            $query = "UPDATE 
                            {$this->table}
                        SET
                            category = :category
                        WHERE 
                            id = :id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Parameters
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);

            // Execute Query
            if($stmt->execute()) {
                // Return true on success
                return true;
            } else {
                // Return false and print error on failure
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        // Delete Category
        public function delete() {
            // Create Update Query
            $query = "DELETE FROM 
                            {$this->table}
                        WHERE 
                            id = :id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind Parameter
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()) {
                // Return true on success
                return true;
            } else {
                // Return false and print error on failure
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }
    }