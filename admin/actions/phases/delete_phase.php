<?php

require('../check-login.php');
require('../../class/phase.class.php');




$phase = new Phase();


if (isset($_POST['deletePhaseID'])) {
   
    $phase_id = $_POST['deletePhaseID'];
    $phase->deletePhase($phase_id);

    $response = array(
        'status' => 'ok'

    );
    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response);
    exit; // Output the JSON response


}
  



// Check if the form is submitted
