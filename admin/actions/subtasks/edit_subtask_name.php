<?php

require('../check-login.php');
require('../../class/subtask.class.php');




$subtask = new Subtask();




$subtask_id = $_POST['subtask_id'];
$subtask_name = $_POST['editSubtaskNameInput'];
$subtask->updateSubtaskName($subtask_id, $subtask_name);

$response = array(
    "status" => "success"
);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
