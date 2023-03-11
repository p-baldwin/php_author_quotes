<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $author_object = new Author($db);

    // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));

    // Assign Input from User to the New Author
    $author_object->author = $data->author;

    // Create Author
    if($author_object->create()) {
        echo json_encode(
            array('message' => 'Author Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Created')
        );
    }