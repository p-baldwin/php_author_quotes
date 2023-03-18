<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');

    // include_once '../../config/Database.php';
    // include_once '../../models/Quote.php';
    
    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Quote Object
    // $quote = new Quote($db);

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
    $quote_object->id = $id; // isset($_GET['id']) ? $_GET['id'] : die();

    // Get Quote
    $quote_object->read_single();

    // Create Array
    $quote_array = array(
        'id' => $quote_object->id,
        'quote' => html_entity_decode($quote_object->quote),
//        'author_id' => $quote_object->author_id,
        'author' => $quote_object->author_name,
//        'category_id' => $quote_object->category_id,
        'category' => $quote_object->category_name
    );

    // Turn into JSON and Output
    print_r(json_encode($quote_array));
