<?php
// A function to check whether any rows with $id exist in the table. A model 
// object must be created and passed into the function to test that the id
// provided is valid.
function isValid($id, $model) {
    // Ensure the model has the id to be tested.
    $model->id = $id;

    // If the id is valid, read_single() > 0 and evaluates to boolean true.
    // An invalid id will return 0 rows. Zero evaluates to boolean false.
    return ($model->read_single() > 0) ? true : false;
}
?>