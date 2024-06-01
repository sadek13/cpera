<?php

require('../check-login.php');
require('../../class/task.class.php');





$task = new Task();

// $project_id=$_POST['project_id'];

// if (isset($_POST['project_id'])) {


//     $project_id = $_POST['project_id'];
//     $taskName = $_POST['task_name'];
//     $e_start_date_str = $_POST['e_start_date'];
//     $e_end_date_str = $_POST['e_end_date'];

//     $e_start_date = DateTime::createFromFormat('D M d Y H:i:s e+', $e_start_date_str);
//     $e_end_date = DateTime::createFromFormat('D M d Y H:i:s e+', $e_end_date_str);

//     var_dump($e_start_date);

//     // Format DateTime objects to MySQL date format
//     $e_start_date_formatted = $e_start_date->format("d-m-Y");

//     var_dump($e__date_formatted);
//     $e_end_date_formatted = $e_end_date->format("d-m-Y");


//     $task->addTask($project_id, $taskName, $e_start_date_formatted, $e_end_date_formatted);


// }

if (isset($_POST['phase_id'])) {
    $phase_id = $_POST['phase_id'];
    $task_name = $_POST['task_name'];
    $task->addTaskByPhaseID($phase_id, $task_name);
}

$response = array(
    'status' => 'ok',
    'message' => 'Task added successfully'
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response



// Check if the form is submitted
