<?php

require('../check-login.php');
require('../../class/subtask.class.php');
require('../../class/task.class.php');




$subtask = new Subtask();
$task = new Task();

// var_dump($_POST);


$subtask_id = $_POST['subtask_id'];

// var_dump($currentDate);
// var_dump($task_due);


   if($subtask->deleteSubTask($subtask_id)==0){

    $response = array(
        "status" => "success"
    );
    
header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); 
    exit;
   }

$response = array(
    "status" => "error",
    "message" => "Error occured while deleteing subtask"
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
