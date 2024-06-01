<?php

require('../check-login.php');
require('../../class/project.class.php');
require('../../class/phase.class.php');
require('../../class/task.class.php');
require('../../class/subtask.class.php');







$project = new Project();
$phase = new Phase();
$task = new Task();
$subtask = new Subtask();


$user_id = $_SESSION['user_id'];
$project_id = $_POST['project_id'];
$due_date = $_POST['due_date'];
$priority = $_POST['priority'];
$status = $_POST['status'];

$allPhases = $project->getAllPhasesDetails($project_id);



foreach ($allPhases as &$phaseItem) {
    $phase_id = $phaseItem['phase_id'];



    $allTasks = $phase->getAllTasksDetails($phase_id, $due_date, $priority, $status);

    foreach ($allTasks as &$taskItem) {
        $task_id = $taskItem['task_id'];
        $allSubtasks = $task->getAllSubtasksDetails($task_id);
        foreach ($allSubtasks as &$subtaskItem) {
            $subtask_id = $subtaskItem['subtask_id'];
            $ad = $subtask->getSubTaskAssigneesDetails($subtask_id);
            $docdetails = $subtask->getSubTaskDocDetails($subtask_id);

            $subtaskItem["assignees"] = $ad;
            $subtaskItem["docdetails"] = $docdetails;
        }
        unset($subtaskItem);
        $taskItem['subtasks'] = $allSubtasks;
    }

    unset($taskItem);

    $phaseItem['tasks'] = $allTasks;
}
unset($phaseItem);




if ($_SESSION['user_type'] == 'regular' && !$_SESSION['isPM']) {





    $allPhases = $project->getAProjectDetailsForUserListView($user_id, $project_id);




    foreach ($allPhases as &$phaseItem) {
        $phase_id = $phaseItem['phase_id'];



        $allTasks = $phase->getAllTasksDetails($phase_id, $due_date, $priority, $status);

        foreach ($allTasks as &$taskItem) {
            $task_id = $taskItem['task_id'];
            $allSubtasks = $task->getAllSubtasksDetailsForUser($task_id,$user_id);
            foreach ($allSubtasks as &$subtaskItem) {
                $subtask_id = $subtaskItem['subtask_id'];
                $ad = $subtask->getSubTaskAssigneesDetails($subtask_id);
                $docdetails = $subtask->getSubTaskDocDetails($subtask_id);

                $subtaskItem["assignees"] = $ad;
                $subtaskItem["docdetails"] = $docdetails;
            }
            unset($subtaskItem);
            $taskItem['subtasks'] = $allSubtasks;
        }

        unset($taskItem);

        $phaseItem['tasks'] = $allTasks;
    }
    unset($phaseItem);
}


// var_dump($_POST['due_date']);
$response = array(
    "status" => "success",
    "allDetails" => $allPhases,
    "due_date" => $due_date,
    "priority" => $priority,
    "task_status" => $status
);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
