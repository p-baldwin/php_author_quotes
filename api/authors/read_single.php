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

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(!isValid($id, $author_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        exit();
    }
    
    // Get Author ID
    $author_object->id = $id; // isset($_GET['id']) ? $_GET['id'] : die();

    // Get Author
    $author_object->read_single();

    // Create Array
    $author_array = array(
        'id' => $author_object->id,
        'author' => $author_object->author
    );

    // Turn into JSON and Output
    echo json_encode($author_array);
