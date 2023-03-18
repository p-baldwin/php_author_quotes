<?php
/*  authors/update.php provides an endpoint to modify an author record in the 
    database identified by the row id. It may modify each column of a record 
    except the id. It checks that input has been provided and that it is valid 
    before attempting to modify the record. Errors return messages about the 
    reason for failed attempts to modify the author.

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

    // Check that we have a Author name from the user. If we do, attempt to 
    // update the existing author.
    if(empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Set ID of Author to Update
    $author_object->id = $data->id;

    // Assign Input from User to Update the Specific Author
    $author_object->author = $data->author;

    // Update Author
    try {
        $author_object->update();
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