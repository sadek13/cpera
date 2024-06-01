<?php

require('../check-login.php');
require('../../class/task.class.php');






$task = new Task();




$task_id = $_POST['task_id'];
$due_date = $_POST['task_due_date'];



$update = $task->updateTaskDueDateByTaskID($task_id, $due_date);


// $new_due_date=$taskDetails['due_date']->format('d-m Y');

// var_dump($new_due_date);

if($update == true){
$response = array(
    'status' => 'success',
    'message_tasks' => 'task due date changed',
    'message_subtasks' => 'subtask(s) due date(s) changed'


);
}
else{
    $response = array(
        'status' => 'error',
        'message'=>"task due date can't be after phase due date"
    
    
    );
}

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response



// Check if the form is submitted
