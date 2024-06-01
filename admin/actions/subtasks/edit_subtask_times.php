<?php

require('../check-login.php');
require('../../class/subtask.class.php');
require('../../class/task.class.php');





$task = new Task();
$subtask = new SubTask();


if (isset($_POST['st_new_date']) && isset($_POST['subtask_id'])) {


    $subtask_id = $_POST['subtask_id'];
    $st_new_due_date = $_POST['st_new_date'];


    $update = $subtask->updateSubtaskDueDateBySubtaskID($subtask_id, $st_new_due_date);

    if ($update) {
        $response = array(
            "status" => "ok",
            "message_subtasks" => "subtask due date updated successfully"
        );
    } else {
        $response = array(
            "status" => "error",
            "message_error" => "subtask due date can't be after task due date"
        );
    }
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response
    exit;
}

    // if($task_dates[0]['start_date'] > $sb_end_date){
    //     $response=array(
    //         "status"=>"error",
    //         "message"=>"end date can't be before task's start date"
    //     );
    //         header('Content-Type: application/json');
    //     // Set the Content-Type header
    //     echo json_encode($response); // Output the JSON response
    //     exit;
    // }


    // if($task_dates[0]['end_date'] < $sb_end_date){
    //     $response=array(
    //         "status"=>"error",
    //         "message"=>"end date can't be after task's end date"
    //     );
    //         header('Content-Type: application/json');
    //     // Set the Content-Type header
    //     echo json_encode($response); // Output the JSON response

    //     exit;
    // }


    // $response=array(
    //     "status"=>"ok",
    //     "message"=>"end date set successfully"
    // );
    //     header('Content-Type: application/json');
    // // Set the Content-Type header
    // echo json_encode($response); // Output the JSON response

    // }



    // if (isset($_POST['sb-start-date']) && isset($_POST['substask_id'])) {


    //     $subtask_id = $_POST['subtask_id'];
    //     $sb_start_date = $_POST['sb-start-date'];

    // $task_dates=$task->getTaskDatesBySubtaskID($subtask_id);
    // $subtask_end_date=$subtask->getSubtaskEnddateBySubtaskID($subtask_id);


    // if($sb_start_date > $subtask_end_date){
    //     $response=array(
    //         "status"=>"error",
    //         "message"=>"start date can't be after task's end date"
    //     );
    //         header('Content-Type: application/json');
    //     // Set the Content-Type header
    //     echo json_encode($response); // Output the JSON response
    //     exit;
    // }

    // if($task_dates[0]['start_date'] < $sb_start_date){
    //     $response=array(
    //         "status"=>"error",
    //         "message"=>"start date can't be after task's start date"
    //     );
    //         header('Content-Type: application/json');
    //     // Set the Content-Type header
    //     echo json_encode($response); // Output the JSON response
    //     exit;
    // }

    // if($task_dates[0]['end_date'] < $sb_start_date){
    //     $response=array(
    //         "status"=>"error",
    //         "message"=>"start date can't be after task's end date"
    //     );
    //         header('Content-Type: application/json');
    //     // Set the Content-Type header
    //     echo json_encode($response); // Output the JSON response

    //     exit;
    // }

    // $response = array(
    //     "status" => "ok",
    //     "message" => "start date set successfully"
    // );
    // header('Content-Type: application/json');
    // // Set the Content-Type header
    // echo json_encode($response); // Output the JSON response
