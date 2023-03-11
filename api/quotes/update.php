<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get Raw Quote Data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID of Quote to Update
    $quote->id = $data->id;

    // Assign Input from User to Update the Specific Quote
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Update Quote
    if($quote->update()) {
        echo json_encode(
            array('message' => 'Quote Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Updated')
        );
    }