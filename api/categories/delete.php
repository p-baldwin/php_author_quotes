<?php
/*  categories/delete.php provides an endpoint to delete an existing category 
    record in the database. It checks that input has been provided and that it 
    is valid before attempting to delete the record. Errors return messages 
    about the reason for failed attempts to delete the category.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $category_object)) {
        echo(
            json_encode(
                array(
                    "message" => "category_id Not Found"
                )
            )
        );
        exit();
    }

    // Set ID of Category to Delete
    $category_object->id = $data->id;

    // Delete Category
    try {
        $category_object->delete();
        echo json_encode(
            array('id' => $category_object->id)
        );
    } catch(PDOException $e) {
        // This code executes if the call to delete() fails.
        echo json_encode(
            array('message' => "{$e->getMessage()}")
        );
    }
