<?php

require('../check-login.php');
require('../../class/division.class.php');




// var_dump($_POST);

$division = new Division();


if ($_POST) {
    $division_id=$_POST['currentDivID'];
  

    // $category = $categories->getcategory($name);
    // $result = $category;
    // if ($result) {
    //     $response = array(
    //         'status' => 'error',
    //         'message' => 'The name of category is already exists'
    //     );
    // } else {
        $division->deleteDivision($division_id);

        $response = array(
            'status' => 'ok',
            'message' => 'Division created successfully'
        );
    }

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response



// Check if the form is submitted


?>




