<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    
    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);

    // Get Category ID
    $category_object->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get category
    $category_object->read_single();

    // Create Array
    $category_array = array(
        'id' => $category_object->id,
        'name' => $category_object->category
    );

    // Turn into JSON and Output
    print_r(json_encode($category_array));
