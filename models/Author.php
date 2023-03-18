<?php
// Categories Class
    class Author {
        // DB Connection Properties
        private $conn;
        private $table = 'authors';

        // Author Properties
        public $id;
        public $author;

        // Author Class Constructor. Expects a DB Connection in $db.
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Authors
        public function read() {
            // Create Select Query
            $query = "SELECT
                            id,
                            author
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

            // Get Single Author
            public function read_single() {
                // Create Select Query
                $query = "SELECT 
                                id,
                                author
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
                $numRows = $stmt->rowCount();

                // Set Properties
                if($numRows > 0){
                    $this->id = $row['id'];
                    $this->author = $row['author'];
                }
    
                // Return the number of rows returned from executing Query
                return $numRows;
                }

        // Create New Author
        public function create() {
            // Create Insert Query
            $query = "INSERT INTO 
                            {$this->table}
                            (author)
                        VALUES 
                            (:author)";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Parameters
            $stmt->bindParam(':author', $this->author);

            // Execute Query
            if($stmt->execute()) {
                // Assign the author id to the current object id, then return 
                // true on success
                $this->id = $this->conn->lastInsertId();
                return true;
            } else {
                // Return false and print error on failure
                printf("Error: %s. \n", $stmt->error);
                return false;
            }
        }

        // Update Existing Author
        public function update() {
            // Create Update Query
            $query = "UPDATE 
                            {$this->table}
                        SET
                            author = :author
                        WHERE 
                            id = :id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Parameters
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

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

        // Delete Author
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