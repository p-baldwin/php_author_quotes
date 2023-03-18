<?php
/*  quotes/read.php provides an endpoint to retrieve a group of quote records 
    from the database. It may return all records, those filtered by author 
    and/or category identified by the user. It checks that input has been 
    provided and that it is valid before attempting to return the records. 
    Errors return messages about the reason for failed attempts to retrieve the 
    quote.

    Shared headers, include files, objects, and user data are provided by the
    index.php file. This behavior ensures this endpoint will throw an error if 
    it is used without passing through index.php first.

    Author: Philip Baldwin
    Last Modification: 2023-03-18
 */

    if(!empty($author_id)) {
        // Determine Whether author ID is Valid. Print an error message and exit if not.
        $author_object = new Author($db);
        if(!isValid($author_id, $author_object)) {
            echo(
                json_encode(
                    array(
                        "message" => "author_id Not Found"
                    )
                )
            );
            $author_object = null;
            exit();
        }

        // author_id exists and is valid. Assign it to the quote object
        $quote_object->author_id = $author_id;
    }

    if(!empty($category_id)) {
        // Determine Whether category ID is Valid. Print an error message and exit if not.
        $category_object = new Category($db);
        if(!isValid($category_id, $category_object)) {
            echo(
                json_encode(
                    array(
                        "message" => "category_id Not Found"
                    )
                )
            );
            $category_object = null;
            exit();
        }

        // category_id exists and is valid. Assign it to the quote object
        $quote_object->category_id = $category_id;
    }

    try {
        // Quote query
        $result = $quote_object->read();

        // Get row count
        $numRows = $result->rowCount();

        // Check that there are quotes
        if($numRows > 0) {
            // Quote Array
            $quotes_array = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $quote_item = array(
                    'id' => $id,
                    'quote' => html_entity_decode($quote),
                    'author' => $author_name,
                    'category' => $category_name
                );

                // Push Data
                array_push($quotes_array, $quote_item);
            }

            // Turn into JSON and Output
            echo json_encode($quotes_array);
        } else {
            // No Quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    } catch(PDOException $e) {
        // This code executes if the an error occurs while reading
        echo json_encode(
            array("error" => "{$e->getMessage()}")
        );
    }