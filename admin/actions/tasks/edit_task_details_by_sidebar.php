<?php

require('../check-login.php');
require('../../class/task.class.php');
require('../../class/project.class.php');






$task = new Task();
$project = new Project();


if (isset($_POST['task_name'])) {

  $task_name = $_POST['task_name'];
  $task_id = $_POST['task_id'];
  $response = $task->updateTaskName($task_name, $task_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response


}

if (isset($_POST['task_priority'])) {

  $task_priority = $_POST['task_priority'];
  $task_id = $_POST['task_id'];
  $response = $task->updateTaskPriority($task_priority, $task_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}

if (isset($_POST['task_status'])) {

  $task_status = $_POST['task_status'];
  $task_id = $_POST['task_id'];
  $response = $task->updateTaskStatus($task_status, $task_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}


if (isset($_POST['task_description'])) {

  $task_description = $_POST['task_description'];
  $task_id = $_POST['task_id'];
  $response = $task->updateTaskDescription($task_description, $task_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}

if (isset($_POST['task_completed'])) {


  $task_id = $_POST['task_id'];

  $task_completed = $_POST['task_completed'];

  if ($task_completed == 1) {
    $task_status = 'Completed';
  } else {
    $task_status = 'In Progress';
  }
  
  $task->updateTaskStatus($task_status, $task_id);

  $response = array(
    'status' => 'ok'

  );

  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response
}

if (isset($_POST['phase_id'])) {

  $phase_id = $_POST['phase_id'];
  $task_id = $_POST['task_id'];
  $response = $task->updateTaskPhase($phase_id, $task_id);

  $response = array(
    'status' => 'ok'

  );
  header('Content-Type: application/json');
  // Set the Content-Type header
  echo json_encode($response);
  exit; // Output the JSON response

}





// Check if the form is submitted
