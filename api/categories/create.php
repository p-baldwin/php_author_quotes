<?php
/*  categories/create.php provides an endpoint to create a new category record 
    in the database. It checks that input has been provided and that it is valid 
    before attempting to create the record. Errors return messages about the 
    reason for failed attempts to add a new category.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Check that we have a category name from the user. If we do, attempt to 
    // create the New Category.
    if(empty($data->category)) {
        // User did not provide the category_name
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign Input from User to the New Category
    $category_object->category = $data->category;

    // Create Category In DB
    try {
        $category_object->create();
        echo json_encode(
            array(
                'id' => $category_object->id,
                'category' => $category_object->category
            )
        );
    } catch(PDOException $e) {
        // This code executes if the $data->category exceeds the size of the 
        // table column.
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }
