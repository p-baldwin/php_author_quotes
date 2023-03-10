<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);

    // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));

    // Assign Input from User to the New Category
    $category_object->id = $data->id;
    $category_object->category = $data->category;

    // Create Category
    if($category_object->create()) {
        echo json_encode(
            array('message' => 'Category Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
    }