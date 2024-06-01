<?php

require('../check-login.php');
require('../../class/subtask.class.php');
require('../../class/task.class.php');




$subtask = new Subtask();
$task = new Task();

// var_dump($_POST);


$task_id = $_POST['currentTask_id'];
$subtask_name = $_POST['new_subtask_name'];
$currentDate = date('Y-m-d');
$task_due = $task->getTaskDueDateByTaskID($task_id);

if ($currentDate <= $task_due) {

    $subtask->insertSubTask($task_id, $subtask_name);

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
    "message" => "Make task due date after today's date in order to add a new subtask"
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
