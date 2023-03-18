<?php
/*  quotes/create.php provides an endpoint to create a new quote record in 
    the database. It checks that input has been provided and that it is valid 
    before attempting to create the record. Errors return messages about the 
    reason for failed attempts to add a new quote.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Check that we have a quote, author id, and category id from the user. 
    // If any data is missing, echo a message and exit. Otherwise, attempt to 
    // create the New Quote.
    if(empty($data->quote) 
        || empty($data->author_id) 
        || empty($data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit(0);
    }

    // Determine Whether author ID is Valid. Print an error message and exit if not.
    $author_object = new Author($db);
    if(!isValid($data->author_id, $author_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        $author_object = null;
        exit();
    }

    // Determine Whether category ID is Valid. Print an error message and exit if not.
    $category_object = new Category($db);
    if(!isValid($data->category_id, $category_object)) {
        echo(
            json_encode(
                array(
                    "message" => "category_id Not Found"
                )
            )
        );
        $category_object = null;
        exit();
    }

    // Assign Input from User to the New Quote
    $quote_object->quote = $data->quote;
    $quote_object->author_id = $data->author_id;
    $quote_object->category_id = $data->category_id;

    // Create Quote
    try {
        $quote_object->create();
        echo json_encode(
            array(
                'id' => $quote_object->id,
                'quote' => $quote_object->quote,
                'author_id' => $quote_object->author_id,
                'category_id' => $quote_object->category_id
            )
        );
    } catch(PDOException $e) {
        // This code executes if the call to create() fails.
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }