<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();


if (isset($_POST['filters']['due_date_sort']))
    $due_date_sort = $_POST['filters']['due_date_sort'];

if (isset($_POST['filters']['completion_filter']))
    $completion_filter = $_POST['filters']['completion_filter'];


// var_dump($_SESSION['user_type']);
// var_dump($_SESSION['isPM']);

if ($_SESSION['user_type'] == 'admin') {
    $projectDetails = $project->getAllProjectsDetails($due_date_sort, $completion_filter);
}

$user_id = $_SESSION['user_id'];

// var_dump($user_id);

if ($_SESSION['user_type'] == 'regular' && $_SESSION['isPM']) {

    // var_dump($_POST);

    // var_dump($_POST);


    $projectDetails = $project->getAllProjectsDetailsForPM($user_id, $due_date_sort, $completion_filter);
}

if ($_SESSION['user_type'] == 'regular' && !$_SESSION['isPM']) {

    $projectDetails = $project->getAllProjectsDetailsForUser($user_id, $due_date_sort, $completion_filter);
}

$response = array(
    "status" => "success",
    "details" => $projectDetails,
    "due_date_sort" => $due_date_sort,
    "completion_filter" => $completion_filter
);




header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
exit;
