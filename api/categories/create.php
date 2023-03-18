<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: POST');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

/*     include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);
 */
/*     // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));
 */
    // Check that we have a category name from the user. If we do, attempt to 
    // create the New Category.
    if(empty($data->category)) {
        // User did not provide the category_name
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Assign Input from User to the New Category
    $category_object->category = $data->category;

    // Create Category In DB
    try {
        $category_object->create();
        echo json_encode(
            array(
                'id' => $category_object->id,
                'category' => $category_object->category
            )
        );
    } catch (PDOException $e) {
        // This code executes if the $data->category exceeds the size of the 
        // table column.
        echo json_encode(
                array("error" => "{$e->getMessage()}")
            );
    }
