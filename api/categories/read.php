<?php
/*  categories/read.php provides an endpoint to retrieve a group of category 
    records from the database. It checks that input has been provided and that 
    it is valid before attempting to return the records. Errors return messages 
    about the reason for failed attempts to retrieve the category.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    try {
        // Category read query
        $result = $category_object->read();

        // Get row count
        $numRows = $result->rowCount();

        // Check that there are Categories
        if($numRows > 0) {
            // Category Array
            $categories_array = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $category_item = array(
                    'id' => $id,
                    'category' => $category
                );

                // Push Data
                array_push($categories_array, $category_item);
            }

            // Turn into JSON and Output
            echo json_encode($categories_array);
        } else {
            // No Categories
            echo json_encode(
                array('message' => 'No Categories Found')
            );
        }
    } catch(PDOException $e) {
        // This code executes if the an error occurs while reading
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }