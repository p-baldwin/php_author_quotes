<?php
/*  authors/create.php provides an endpoint to create a new author record in 
    the database. It checks that input has been provided and that it is valid 
    before attempting to create the record. Errors return messages about the 
    reason for failed attempts to add a new author.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // If we don't have an author from the user, complain and exit.
    if(empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign Input from User to the New Author
    $author_object->author = $data->author;

    // Create Author
    try {
        $author_object->create();
        echo json_encode(
            array(
                'id' => $author_object->id,
                'author' => $author_object->author
            )
        );
    } catch(PDOException $e) {
        // This code executes if the $data->author exceeds the size of the 
        // table column.
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }