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

    // Quote query
    $result = $quote->read();

    // Get row count
    $numRows = $result->rowCount();

    // Check that there are quotes
    if($numRows > 0) {
        // Quote Array
        $quotes_array = array();
        $quotes_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_id,
                'author_name' => $author_name,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // Push Data
            array_push($quotes_array['data'], $quote_item);
        }

        // Turn into JSON and Output
        echo json_encode($quotes_array);
    } else {
        // No Quotes
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }