<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author_object = new Author($db);

    // Get Raw Author Data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID of Author to Update
    $author_object->id = $data->id;

    // Assign Input from User to Update the Specific Author
    $author_object->author = $data->author;

    // Update Author
    if($author_object->update()) {
        echo json_encode(
            array('message' => 'Author Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
    }