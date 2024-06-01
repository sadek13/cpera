<?php

require('../check-login.php');
require('../../class/phase.class.php');




$phase = new Phase();




if (isset($_POST['phase_due_date'])) {

    $phase_id = $_POST['phase_id'];
    $phase_due_date = $_POST['phase_due_date'];

    $update = $phase->updatePhaseDueDateByPhaseID($phase_id, $phase_due_date);

    if ($update) {
        $response = array(
            'status' => 'ok',
            'message_phase' => 'phase due date updated successfully',
            'message_tasks' => 'related tasks due date updated successfully',
            'message_subtasks' => 'related subtasks due date updated successfully'

        );
    } else {
        $response = array(
            'status' => 'error',
            'message_error' => "Phase due date can't be after project's due date"

        );
    }
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit; // Output the JSON response


}
  



// Check if the form is submitted
