<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: PUT');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // include_once '../../config/Database.php';
    // include_once '../../models/Quote.php';

    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Quote Object
    // $quote = new Quote($db);

    // // Get Raw Quote Data
    // $data = json_decode(file_get_contents("php://input"));

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
    } catch (PDOException $e) {
        // This code executes if the call to update() fails.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }