<?php
/*  quotes/update.php provides an endpoint to modify a quote record in the 
    database identified by the row id. It may modify each column of a record 
    except the id. It checks that input has been provided and that it is valid 
    before attempting to modify the record. Errors return messages about the 
    reason for failed attempts to modify the quote.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $quote_object)) {
        echo(
            json_encode(
                array(
                    "message" => "No Quotes Found"
                )
            )
        );
        exit();
    }

    // Check that we have a quote, author_id, and category_id from the user. 
    // If we do, attempt to update the existing Quote.
    if(empty($data->quote) 
        || empty($data->author_id) 
        || empty($data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Determine Whether author ID is Valid. Print an error message and exit if not.
    $author_test_object = new Author($db);
    if(!isValid($data->author_id, $author_test_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        $author_test_object = null;
        exit();
    }

    // Determine Whether category ID is Valid. Print an error message and exit if not.
    $category_test_object = new Category($db);
    if(!isValid($data->category_id, $category_test_object)) {
        echo(
            json_encode(
                array(
                    "message" => "category_id Not Found"
                )
            )
        );
        $category_test_object = null;
        exit();
    }

    // Set ID of Quote to Update
    $quote_object->id = $data->id;

    // Assign Input from User to Update the Specific Quote
    $quote_object->quote = $data->quote;
    $quote_object->author_id = $data->author_id;
    $quote_object->category_id = $data->category_id;

    // Update Quote
    try {
        $quote_object->update();
        echo json_encode(
            array(
                'id' => $quote_object->id,
                'quote' => $quote_object->quote,
                'author_id' => $quote_object->author_id,
                'category_id' => $quote_object->category_id
            )
        );
    } catch(PDOException $e) {
        // This code executes if the call to update() fails.
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }