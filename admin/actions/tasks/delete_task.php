<?php

require('../check-login.php');
require('../../class/task.class.php');





$task = new Task();


if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    $task->deleteTask($task_id);

    $response = array(
        'status' => 'ok',

    );

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response

}
