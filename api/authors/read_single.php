<?php
/*  authors/read_single.php provides an endpoint to retrieve a single author 
    record in the database identified by the id sent by the user. It checks 
    that input has been provided and that it is valid before attempting to 
    return the record. Errors return messages about the reason for failed 
    attempts to retrieve the author.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(!isValid($id, $author_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        exit();
    }
    
    // Get Author ID
    $author_object->id = $id;

    try {
        // Get Author
        $author_object->read_single();

        // Create Array
        $author_array = array(
            'id' => $author_object->id,
            'author' => $author_object->author
        );

        // Turn into JSON and Output
        echo json_encode($author_array);
    } catch(PDOException $e) {
        // This code executes if the an error occurs while reading
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }