<?php

require('../check-login.php');
require('../../class/task.class.php');





$task = new Task();


if ($_POST) {
    var_dump($_POST);

    $variableNames = ['task_id', 'phase_id', 'project_id', 'task_name', 'task_description', 'task_status', 'e_start_date', 'e_end_date', 'start_date', 'end_date'];

    // Loop through the variable names
    foreach ($variableNames as $name) {
        // Check if the variable is set in $_POST
        if (isset($_POST[$name])) {
            // Assign its value to a variable of similar name
            ${$name} = $_POST[$name];
        
        } else {
            // If not set, assign an empty string to the variable
            ${$name} = '';
        }
    //  echo($name.'='.${$name});
      }
   

  
$e_start_date = DateTime::createFromFormat('D M d Y H:i:s e+', $e_start_date);
$e_end_date = DateTime::createFromFormat('D M d Y H:i:s e+', $e_end_date);

// Format DateTime objects to MySQL date format
$e_start_date_formatted = $e_start_date->format("Y-m-d");
$e_end_date_formatted = $e_end_date->format("Y-m-d");
var_dump($e_start_date_formatted);

if(isset($_POST['start_date'])) {
  $start_date= DateTime::createFromFormat('D M d Y H:i:s e+', $start_date);
$start_date_formatted = $e_start_date->format("Y-m-d");

}else{
  $start_date_formatted=$e_start_date_formatted;
}

if(isset($_POST['end_date'])) {
  $end_date= DateTime::createFromFormat('D M d Y H:i:s e+', $end_date);
$end_date_formatted = $e_start_date->format("Y-m-d");

}
else{
  $end_date_formatted=$e_end_date_formatted;
}

    // $category = $categories->getcategory($name);
    // $result = $category;
    // if ($result) {
    //     $response = array(
    //         'status' => 'error',
    //         'message' => 'The name of category is already exists'
    //     );
    // } else {
        $task->updateTask(19, $phase_id, $project_id, $task_name, $task_description, $task_status, $e_start_date_formatted, $e_end_date_formatted, $start_date_formatted, $end_date_formatted);
        $response = array(
            'status' => 'ok',
            'message' => 'Task updated successfully'
        );
    }

    if(isset($_POST['gdb'])){

  $response=$project->getAllTasksDetails($project_id);

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); 
    exit;// Output the JSON response
    }
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response


// Check if the form is submitted


?>




