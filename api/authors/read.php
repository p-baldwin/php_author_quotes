<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');

    // include_once '../../config/Database.php';
    // include_once '../../models/Author.php';
    
    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Author Object
    // $author_object = new Author($db);

    // Author read query
    $result = $author_object->read();

    // Get row count
    $numRows = $result->rowCount();

    // Check that there are Categories
    if($numRows > 0) {
        // Author Array
        $authors_array = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push Data
            array_push($authors_array, $author_item);
        }

        // Turn into JSON and Output
        echo json_encode($authors_array);
    } else {
        // No Authors
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }