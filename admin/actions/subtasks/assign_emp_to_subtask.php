<?php

require('../check-login.php');
require('../../class/subtask.class.php');



$subtask = new Subtask();



$subtask_id = $_POST['subtask_id'];


$empsAssignIDsArray = $_POST['emps'];

foreach ($empsAssignIDsArray as $emp_id) {
    $subtask->assignEmpToSubtask($emp_id, $subtask_id);
};

$response = array(
    "status" => "success"
);

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
