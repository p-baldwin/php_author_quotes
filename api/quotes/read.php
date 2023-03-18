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
    // $quote_object = new Quote($db);

    if(!empty($author_id)) {
        // Determine Whether author ID is Valid. Print an error message and exit if not.
        $author_object = new Author($db);
        if(!isValid($author_id, $author_object)) {
            echo(
                json_encode(
                    array(
                        "message" => "author_id Not Found"
                    )
                )
            );
            $author_object = null;
            exit(0);
        }

        // author_id exists and is valid. Assign it to the quote object
        $quote_object->author_id = $author_id;
    }

    if(!empty($category_id)) {
        // Determine Whether category ID is Valid. Print an error message and exit if not.
        $category_object = new Category($db);
        if(!isValid($category_id, $category_object)) {
            echo(
                json_encode(
                    array(
                        "message" => "category_id Not Found"
                    )
                )
            );
            $category_object = null;
            exit(0);
        }

        // category_id exists and is valid. Assign it to the quote object
        $quote_object->category_id = $category_id;
    }

    // Quote query
    $result = $quote_object->read();

    // Get row count
    $numRows = $result->rowCount();

    // Check that there are quotes
    if($numRows > 0) {
        // Quote Array
        $quotes_array = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => html_entity_decode($quote),
//                'author' => $author_id,
                'author' => $author_name,
//                'category_id' => $category_id,
                'category' => $category_name
            );

            // Push Data
            array_push($quotes_array, $quote_item);
        }

        // Turn into JSON and Output
        echo json_encode($quotes_array);
    } else {
        // No Quotes
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }