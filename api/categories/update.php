<?php
/*  categories/update.php provides an endpoint to modify a category record in 
    the database identified by the row id. It may modify each column of a record 
    except the id. It checks that input has been provided and that it is valid 
    before attempting to modify the record. Errors return messages about the 
    reason for failed attempts to modify the category.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
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
