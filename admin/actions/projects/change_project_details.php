<?php

require('../check-login.php');
require('../../class/project.class.php');




$project = new Project();

// var_dump($_POST);


if (isset($_POST['project_status'])) {

  $project_status = $_POST['project_status'];
  $project_id = $_POST['project_id'];
  $project->changeProjectStatus($project_status, $project_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response


}

if (isset($_POST['project_desc'])) {

  $project_desc = $_POST['project_desc'];
  $project_id = $_POST['project_id'];
  $project->changeProjectDesc($project_desc, $project_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}


if (isset($_POST['project_name'])) {

  $project_name  = $_POST['project_name'];
  $project_id = $_POST['project_id'];
  $project->changeProjectName($project_name, $project_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}


  
  



// Check if the form is submitted
