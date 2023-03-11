<?php
    // Quote Class
    class Quote {
        // DB Connection Properties
        private $conn;
        private $table = 'quotes';

        // Post Properties
        public $id;
        public $quote;
        public $category_id;
        public $category_name;
        public $author_id;
        public $author_name;

        // Quote Class Constructor. Expects a DB Connection in $db.
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            // Create Select Query
            $query = "SELECT p.id,
                            p.quote,
                            p.category_id,
                            p.author_id,
                            c.category AS category_name,
                            a.author AS author_name
                        FROM
                            {$this->table} p
                        LEFT JOIN
                            categories c ON p.category_id = c.id
                        LEFT JOIN
                            authors a ON p.author_id = a.id
                        ORDER BY
                            p.id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            // Return results of executing Query
            return $stmt;
        }

        // Get Single Quote
        public function read_single() {
            // Create Select Query
            $query = "SELECT p.id,
                            p.quote,
                            p.category_id,
                            p.author_id,
                            c.category AS category_name,
                            a.author AS author_name
                        FROM
                            {$this->table} p
                        LEFT JOIN
                            categories c ON p.category_id = c.id
                        LEFT JOIN
                            authors a ON p.author_id = a.id
                        WHERE
                            p.id = :id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Parameter to Query
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->author_name = $row['author_name'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];

            // Return results of executing Query
            return $stmt;
        }

        // Create New Quote
        public function create() {
            // Create Insert Query
            $query = "INSERT INTO 
                            {$this->table}
                            (quote,
                            author_id,
                            category_id)
                        VALUES 
                            (:quote,
                            :author_id,
                            :category_id)";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind Parameters
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

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

        // Update Existing Quote
        public function update() {
            // Create Update Query
            $query = "UPDATE 
                            {$this->table}
                        SET
                            quote = :quote,
                            author_id = :author_id,
                            category_id = :category_id
                        WHERE 
                            id = :id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Sanitize Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind Parameters
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
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
        
        // Delete Post
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