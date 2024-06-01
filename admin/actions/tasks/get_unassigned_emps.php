<?php

require('../check-login.php');
require('../../class/subtask.class.php');


// var_dump($_POST);



$subtask = new Subtask();

$subtask_id = $_POST['st_id'];
$division_id = $_POST['division_id'];
$filter = $_POST['filter'];
// var_dump($filter);

$unAss = $subtask->getNonAssignedEmpsBySubtaskIDAndDivID($subtask_id, $division_id, $filter);

$response = $unAss;

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response


// Check if the form is submitted
