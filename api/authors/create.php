<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: POST');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // include_once '../../config/Database.php';
    // include_once '../../models/Author.php';

    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Author Object
    // $author_object = new Author($db);

    // // Get Raw User Input Data
    // $data = json_decode(file_get_contents("php://input"));

    // If we don't have an author from the user, complain and exit.
    if(empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign Input from User to the New Author
    $author_object->author = $data->author;

    // Create Author
    try {
        $author_object->create();
        echo json_encode(
            array(
                'id' => $author_object->id,
                'author' => $author_object->author
            )
        );
    } catch (PDOException $e) {
        // This code executes if the $data->author exceeds the size of the 
        // table column.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }