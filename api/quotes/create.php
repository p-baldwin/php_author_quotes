<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: POST');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // include_once '../../config/Database.php';
    // include_once '../../models/Quote.php';

    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Blog Post Object
    // $quote = new Quote($db);

    // // Get Raw User Input Data
    // $data = json_decode(file_get_contents("php://input"));

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
    } catch (PDOException $e) {
        // This code executes if the call to create() fails.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }