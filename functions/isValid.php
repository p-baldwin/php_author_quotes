<?php
// A function to check whether any rows with $id exist in the table.
function isValid($id, $model) {
    // Ensure the model has the id to be tested.
    $model->id = $id;

    // If the id is valid rowCount() > 0 and evaluates to boolean true.
    // An invalid id will return 0 rows. Zero evaluates to boolean false.
    return $model->read_single() > 0;
}
?>