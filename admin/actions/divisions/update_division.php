<?php

require('../check-login.php');
require('../../class/division.class.php');





$division = new Division();




if ($_POST) {
    $div_name = $_POST['editDivInput'];
  $div_id=$_POST['div_id'];

 

    // $category = $categories->getcategory($name);
    // $result = $category;
    // if ($result) {
    //     $response = array(
    //         'status' => 'error',
    //         'message' => 'The name of category is already exists'
    //     );
    // } else {
        $division->updateDivsion($div_name,$div_id,'');

        $response = array(
            'status' => 'ok',
            'message' => 'Division Updated successfully'
        );
    }

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response



// Check if the form is submitted


?>




