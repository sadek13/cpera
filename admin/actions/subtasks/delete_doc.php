<?php

require('../check-login.php');
require('../../class/subtask.class.php');
require('../../class/task.class.php');




$subtask = new Subtask();
$task = new Task();

// var_dump($_POST);

if(isset($_POST['image_id'])){

$image_id=$_POST['image_id'];




    $subtask->deleteDoc($image_id);

    $response = array(
        "status" => "success"
    );

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit;

}