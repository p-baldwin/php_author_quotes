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

    // Category read query
    $result = $category_object->read();

    // Get row count
    $numRows = $result->rowCount();

    // Check that there are Categories
    if($numRows > 0) {
        // Category Array
        $categories_array = array();
        $categories_array['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push Data
            array_push($categories_array['data'], $category_item);
        }

        // Turn into JSON and Output
        echo json_encode($categories_array);
    } else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }