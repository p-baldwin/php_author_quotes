<?php
/*  authors/read.php provides an endpoint to retrieve a group of author records 
    from the database. It checks that input has been provided and that it is 
    valid before attempting to return the records. Errors return messages about 
    the reason for failed attempts to retrieve the author.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    try {
        // Author read query
        $result = $author_object->read();

        // Get row count
        $numRows = $result->rowCount();

        // Check that there are Categories
        if($numRows > 0) {
            // Author Array
            $authors_array = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $author_item = array(
                    'id' => $id,
                    'author' => $author
                );

                // Push Data
                array_push($authors_array, $author_item);
            }

            // Turn into JSON and Output
            echo json_encode($authors_array);
        } else {
            // No Authors
            echo json_encode(
                array('message' => 'No Authors Found')
            );
        }
    } catch(PDOException $e) {
        // This code executes if the an error occurs while reading
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }