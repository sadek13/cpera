<?php

require('../check-login.php');
require('../../class/task.class.php');
require('../../class/project.class.php');
require('../../class/subtask.class.php');






$task = new Task();
$project = new Project();
$subtask = new SubTask();


if (isset($_POST['key'])) {

    if ($_POST['key'] == 'forDocs') {
        $subtask_id = $_POST['subtask_id'];
        $ad = $subtask->getSubTaskAssigneesDetails($subtask_id);
        $docdetails = $subtask->getSubTaskDocDetails($subtask_id);

        $response = array(
            'status' => 'success',
            'ad' => $ad,
            'docs' => $docdetails

        );

        header('Content-Type: application/json');
        // Set the Content-Type header
        echo json_encode($response);
        exit; // Output the JSON response

    }
} else {

    $task_id = $_POST['task_id'];
    $sort_by = $_POST['sort_by'];

    $subtasksArrays = array();
    $taskDetails = $task->getTaskDetails(19);

    $subtasksIDs = $subtask->getSubtasksDetails($task_id, $sort_by);

    foreach ($subtasksIDs as $sub) {
        $subtask_id = $sub["subtask_id"];
        var_dump($subtask_id);
        $ad = $subtask->getSubTaskAssigneesDetails($subtask_id);
        $docdetails = $subtask->getSubTaskDocDetails($subtask_id);

        $sub["assignees"] = $ad;
        $sub["docdetails"] = $docdetails;
        array_push($subtasksArrays, $sub);
    }


    $response = array(
        'status' => 'ok'

    );

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($subtasksArrays);
    exit; // Output the JSON response

    // Check if the form is submitted
}
