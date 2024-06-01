<?php

require('../check-login.php');
require('../../class/subtask.class.php');
require('../../class/task.class.php');




$subtask = new Subtask();
$task = new Task();


// if (isset($_POST['subtask_completed'])) {




//     if ($subtask_completed == 1) {
//         $subtask_status = 'Completed';
//     } else {
//         $subtask_status = 'In Progress';
//     }


//     $subtask->editSubtaskStatus($subtask_status, $subtask_id);


//     $response = array(
//         "status" => "success"
//     );

//     header('Content-Type: application/json');
//     // Set the Content-Type header
//     echo json_encode($response); // Output the JSON response
//     exit;
//     // Check if the form is submitted


// }


if (isset($_POST['subtask_completed'])) {

    $subtask_id = $_POST['subtask_id'];
    $subtask_completed = $_POST['subtask_completed'];


    if ($subtask_completed == 1) {
        $subtask_status = 'Completed';
    } else {
        $subtask_status = 'In Progress';
    }
}

if (isset($_POST['subtask_status'])) {
    $subtask_id = $_POST['subtask_id'];
    $subtask_status = $_POST['subtask_status'];
}


// var_dump($currentDate);
// var_dump($task_due);


$subtask->editSubtaskStatus($subtask_status, $subtask_id);

$task_id = $subtask->getTaskIDBySubtaskID($subtask_id);

$task->changeTaskStatusbySubtasksStatuses($task_id);

$response = array(
    "status" => "success"
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
exit;
