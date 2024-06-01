<?php

require('../check-login.php');
require('../../class/project.class.php');
require('../../class/phase.class.php');
require('../../class/task.class.php');






$project = new Project();
$phase = new Phase();
$task = new Task();


$user_id = $_SESSION['user_id'];
$due_date = $_POST['due_date'];
$priority = $_POST['priority'];
$status = $_POST['status'];



$allProjects = $project->getAllProjectsDetailsForUserListView($user_id);

foreach ($allProjects as &$projectItem) {

    $project_id = $projectItem['project_id'];

    $allPhases = $project->getAProjectDetailsForUserListView($user_id, $project_id);


    foreach ($allPhases as &$phaseItem) {
        $phase_id = $phaseItem['phase_id'];



        $allTasks = $phase->getAllTasksDetails($phase_id, $due_date, $priority, $status);

        foreach ($allTasks as &$taskItem) {
            $task_id = $taskItem['task_id'];
            $allSubtasks = $task->getAllSubtasksDetails($task_id);
            $taskItem['subtasks'] = $allSubtasks;
        }

        unset($taskItem);

        $phaseItem['tasks'] = $allTasks;
    }
    unset($phaseItem);
    $projectItem['phases'] = $allPhases;
}
unset($projectItem);


// var_dump($_POST['due_date']);
$response = array(
    "status" => "success",
    "allDetails" => $allProjects,
    "due_date" => $due_date,
    "priority" => $priority,
    "task_status" => $status
);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
