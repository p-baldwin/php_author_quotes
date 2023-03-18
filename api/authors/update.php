<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: PUT');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // include_once '../../config/Database.php';
    // include_once '../../models/Author.php';

    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Author Object
    // $author_object = new Author($db);

    // // Get Raw Author Data
    // $data = json_decode(file_get_contents("php://input"));

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $author_object)) {
        echo(
            json_encode(
                array(
                    "message" => "author_id Not Found"
                )
            )
        );
        exit();
    }

    // Check that we have a Author name from the user. If we do, attempt to 
    // update the existing author.
    if(empty($data->author)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Set ID of Author to Update
    $author_object->id = $data->id;

    // Assign Input from User to Update the Specific Author
    $author_object->author = $data->author;

    // Update Author
    try {
        $author_object->update();
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