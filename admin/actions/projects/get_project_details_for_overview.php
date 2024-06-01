


<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();




$project_id = $_POST['project_id'];

$projectDetails = $project->getProjectDetails($project_id);
$projectManagers = $project->getProjectManagersByProjectId($project_id);
$projectPhases = $project->getProjectPhasesByProjectId($project_id);

foreach ($projectPhases as &$phase) {
    $phase_id = $phase['phase_id'];

    $percent = $project->getPhasePercentage($phase_id);

    $phase['percent'] = $percent;
}
unset($phase);


$response = array(
    "status" => "success",
    "details" => $projectDetails,
    "managers" => $projectManagers,
    "phases" => $projectPhases
);


header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response

// Check if the form is submitted
