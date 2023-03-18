<?php
    // Headers
    // header('Access-Control-Allow-Origin: *');
    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Methods: DELETE');
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
        echo(
            json_encode(
                array(
                    "message" => "category_id Not Found"
                )
            )
        );
        exit();
    }

    // Set ID of Category to Delete
    $category_object->id = $data->id;

    // Delete Category
    try {
        $category_object->delete();
        echo json_encode(
            array('id' => $category_object->id)
        );
    } catch(PDOException $e) {
        // This code executes if the call to delete() fails.
        echo json_encode(
            array('message' => "{$e->getMessage()}")
        );
    }
