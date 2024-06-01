<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();


$user_id = $_POST['user_id'];


$project->removeProjectManager($user_id);

$response = array(
    "status" => "success"

);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
