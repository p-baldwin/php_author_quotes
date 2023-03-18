<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');

/*     include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    
    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);
 */

    // Create Default Message Array
    // $category_array = array("message" => "Uncaught Error");

    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(!isValid($id, $category_object)) {
        echo(
            json_encode(
                array(
                    "message" => "category_id Not Found"
                )
            )
        );
        exit();
    }

    // Get Category ID
    $category_object->id = $id; // isset($_GET['id']) ? $_GET['id'] : die();

    // Get category (Do not rely on isValid to populate Category object.)
    $category_object->read_single();

    // Create Array
    $category_array = array(
        'id' => $category_object->id,
        'category' => $category_object->category
    );

    // Turn into JSON and Output
echo json_encode($category_array);