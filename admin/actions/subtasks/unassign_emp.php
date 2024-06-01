<?php

require('../check-login.php');
require('../../class/subtask.class.php');



$subtask = new Subtask();


// var_dump($_POST);

$subtask_id = $_POST['subtask_id'];

$assId = $_POST['ass_id'];


$subtask->unassignEmp($assId,$subtask_id);


$response = array(
    "status" => "success"
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
