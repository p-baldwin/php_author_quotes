<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once '../../functions/isValid.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $category_object = new Category($db);

    // Select the appropriate endpoint based on the method used
    switch($method) {
        // Determine if the use is search for single category or many categories.
        case 'GET':
            if($id) {
                echo('read_once');
                include_once "./read_single.php";
            } else {
                echo('read');
                include_once './read.php';
            }
            break;
        case 'POST':
            include_once './create.php';
            break;
        case 'PUT':
            include_once './update.php';
            break;
        case 'DELETE':
            include_once './delete.php';
            break;
        default:
            echo('Fail');
    }
?>