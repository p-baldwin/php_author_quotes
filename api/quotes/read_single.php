<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    
    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote = new Quote($db);

    // Get Quote ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Quote
    $quote->read_single();

    // Create Array
    $quote_array = array(
        'id' => $quote->id,
        'quote' => html_entity_decode($quote->quote),
        'author_id' => $quote->author_id,
        'author_name' => $quote->author_name,
        'category_id' => $quote->category_id,
        'category_name' => $quote->category_name
    );

    // Turn into JSON and Output
    print_r(json_encode($quote_array));
