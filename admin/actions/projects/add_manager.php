<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();


$employee_id = $_POST['e_id'];
$project_id = $_POST['project_id'];

if ($project->addProjectManager($employee_id, $project_id) == true) {


    $response = array(
        "status" => "success"

    );



    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response
    exit;

} else {
    $response = array(
        "status" => "error",
        "message" => "Manager already assigned"

    );



    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit;
}

// Check if the form is submitted
