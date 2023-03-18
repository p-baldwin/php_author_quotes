<?php
/*  quotes/index.php centralizes the decision about which endpoint should be 
    returned to a user based on the request method used. It retrieves input  
    sent by the user and makes that data available to all endpoints. The Quotes 
    object, Database object, and include files shared by all endpoints get 
    created here as well. 

    Author: Philip Baldwin
    Last Modification: 2023-03-18

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    // Assign the id, author_id, and category_id provided if provided by the 
    // user or null to each one not supplied.
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
    include_once '../../functions/isValid.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quote_object = new Quote($db);

    // Select the appropriate endpoint based on the method used
    switch($method) {
        // Determine if the use is search for single quote or many quotes.
        case 'GET':
            if($id && empty($author_id) && empty($category_id)) {
                include_once "./read_single.php";
            } else {
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