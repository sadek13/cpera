<?php

require('../check-login.php');
require('../../class/task.class.php');





$task = new Task();




$task_id = $_POST['task_id'];

$taskDetails = $task->getTaskDetails_for_sidebar($task_id);


// $new_due_date=$taskDetails['due_date']->format('d-m Y');

// var_dump($new_due_date);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($taskDetails); // Output the JSON response



// Check if the form is submitted
