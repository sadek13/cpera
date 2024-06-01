<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();




if (isset($_POST['project_due_date'])) {

    $project_id = $_POST['project_id'];
    $project_due_date = $_POST['project_due_date'];

    $update=$project->updateProjectDueDateByProjectID($project_id, $project_due_date);

    if($update){
    $response = array(
        'status' => 'ok',
        'message_project' => 'project due date updated successfully',
        'message_phases' => 'related phases due date updated successfully',
        'message_tasks' => 'related tasks due date updated successfully',
        'message_subtasks' => 'related subtasks due date updated successfully'
    );

}
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit; // Output the JSON response


}
  



// Check if the form is submitted
