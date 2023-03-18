<?php
/*  The Quote Class encapsulates all of the properties and methods required to 
    interact with the quotes table of the database provided to it. The database 
    passed to the class on construction must have a table named quotes with 
    four columns: id, quote, author_id, and category_id.

    The methods read, read_single, create, update, and delete provide the data 
    requested by the quotes api endpoints by the same name.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

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
                            authors a ON p.author_id = a.id";

            // If an author_id and/or category_id are provided, create the where 
            // clause needed to filter the query to provide only the desired rows.
            if(!empty($this->author_id) && !empty($this->category_id)) {
                // author_id and category_id provided
                $query .= " WHERE
                                p.author_id = :author_id 
                                AND 
                                p.category_id = :category_id";
            } else if(!empty($this->author_id)) {
                // author_id provided
                $query .= " WHERE
                                p.author_id = :author_id";
            } else if(!empty($this->category_id)) {
                // category_id provided
                $query .= " WHERE
                                p.category_id = :category_id";
            }

            // Ensure the returned records default to order by id ascending
            $query .= " ORDER BY p.id";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            if(!empty($this->author_id) && !empty($this->category_id)) {
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);
            } else if(!empty($this->author_id)) {
                $stmt->bindParam(':author_id', $this->author_id);
            } else if(!empty($this->category_id)) {
                $stmt->bindParam(':category_id', $this->category_id);
            }

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
            $numRows = $stmt->rowCount();

            // Set Properties
            if($numRows > 0){
                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->author_id = $row['author_id'];
                $this->author_name = $row['author_name'];
                $this->category_id = $row['category_id'];
                $this->category_name = $row['category_name'];
            }

            // Return the number of rows returned from executing Query
            return $numRows;
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
                // Assign the category id to the current object id, then return 
                // true on success
                $this->id = $this->conn->lastInsertId();
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