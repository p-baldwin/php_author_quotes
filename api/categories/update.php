<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: PUT');
    // header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

/*     include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);
 */
/*     // Get Raw Category Data
    $data = json_decode(file_get_contents("php://input"));
 */
    // Determine Whether ID is Valid. Print an error message and exit if not.
    if(empty($data->id) || !isValid($data->id, $category_object)) {
        echo json_encode(
            array(
                "message" => "category_id Not Found"
            )
        );
        exit();
    }

    // Check that we have a category name from the user. If we do, attempt to 
    // update the existing Category.
    if(empty($data->category)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Set ID of Category to Update
    $category_object->id = $data->id;

    // Assign Input from User to Update the Specific Category
    $category_object->category = $data->category;

    // Update Category
    try {
        $category_object->update();
        echo json_encode(
            array(
                'id' => $category_object->id, 
                'category' => $category_object->category
            )
        );
    } catch(PDOException $e) {
        // This code executes if the $data->category exceeds the size of the 
        // table column.
        echo json_encode(
            array('message' => "{$e->getMessage()}")
        );
    }
