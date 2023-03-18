<?php
/*  quotes/read_single.php provides an endpoint to retrieve a single quote 
    record in the database identified by the id sent by the user. It checks 
    that input has been provided and that it is valid before attempting to 
    return the record. Errors return messages about the reason for failed 
    attempts to retrieve the quote.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(!isValid($id, $quote_object)) {
        echo(
            json_encode(
                array(
                    "message" => "No Quotes Found"
                )
            )
        );
        exit();
    }

    // Get Quote ID
    $quote_object->id = $id;

    try {
        // Get Quote
        $quote_object->read_single();

        // Create Array
        $quote_array = array(
            'id' => $quote_object->id,
            'quote' => html_entity_decode($quote_object->quote),
            'author' => $quote_object->author_name,
            'category' => $quote_object->category_name
        );

        // Turn into JSON and Output
        echo json_encode($quote_array);
    } catch(PDOException $e) {
        // This code executes if the an error occurs while reading
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }