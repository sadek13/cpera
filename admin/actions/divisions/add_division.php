<?php

require('../check-login.php');
require('../../class/division.class.php');





$division = new Division();


if ($_POST) {
    $name = $_POST['addDivInput'];
// $colorCode=$_POST['colorCode'];
  

    // $category = $categories->getcategory($name);
    // $result = $category;
    // if ($result) {
    //     $response = array(
    //         'status' => 'error',
    //         'message' => 'The name of category is already exists'
    //     );
    // } else {
      $division_id=  $division->insertDivsion($name,'');

        $response = array(
            'status' => 'ok',
            'message' => 'Division created successfully',
            'division_id'=>$division_id
        );
    }

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response



// Check if the form is submitted


?>




