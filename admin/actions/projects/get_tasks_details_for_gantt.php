<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();




$project_id = $_POST['project_id'];

$tasksDetails=$project->getAllTasksDetails($project_id);

$response = array(
    "status" => "success",
    "tasks" => $tasksDetails
);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted

?>
