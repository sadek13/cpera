<?php

require('../check-login.php');
require('../../class/phase.class.php');




$phase = new Phase();



if (isset($_POST['addPhaseName'])) {

    $phase_name = $_POST['addPhaseName'];
    $phase_color = $_POST['addPhaseColor'];
    $project_id = $_POST["addPhaseProjectID"];
    $phase->addPhase($phase_name, $phase_color, $project_id);

    $response = array(
        'status' => 'ok'

    );
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit; // Output the JSON response


}
  



// Check if the form is submitted
