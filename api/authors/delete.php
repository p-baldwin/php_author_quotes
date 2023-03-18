<?php
/*  authors/delete.php provides an endpoint to delete an existing author record 
    in the database. It checks that input has been provided and that it is valid 
    before attempting to delete the record. Errors return messages about the 
    reason for failed attempts to delete the author.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $author_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        exit();
    }

    // Set ID of Author to Delete
    $author_object->id = $data->id;

    // Delete Author
    try{
        $author_object->delete();
        echo json_encode(
            array('id' => $author_object->id)
        );
    } catch(PDOException $e) {
        // This code executes if the call to delete() fails.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }