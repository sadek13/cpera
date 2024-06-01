<?php

require('../check-login.php');
require('../../class/division.class.php');





$division = new Division();


$project_id = $_POST['project_id'];

$managers = $division->getMembersByDivName('project management', $project_id);




$response = array(
    'status' => 'ok',
    'managers' => $managers
);



header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response



// Check if the form is submitted
