<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: DELETE');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // include_once '../../config/Database.php';
    // include_once '../../models/Quote.php';

    // // Instantiate DB and Connect
    // $database = new Database();
    // $db = $database->connect();

    // // Instantiate Quote Object
    // $quote = new Quote($db);

    // // Get Raw Quote Data
    // $data = json_decode(file_get_contents("php://input"));

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $quote_object)) {
        echo(
            json_encode(
                array(
                    "message" => "No Quotes Found"
                )
            )
        );
        exit();
    }

        // Set ID of Quote to Delete
    $quote_object->id = $data->id;

    // Delete Quote
    try {
        $quote_object->delete();
        echo json_encode(
            array('id' => $quote_object->id)
        );
    } catch (PDOException $e) {
        // This code executes if the call to delete() fails.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }