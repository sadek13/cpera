<?php

require('../check-login.php');
require('../../class/phase.class.php');




$phase = new Phase();




if (isset($_POST['editPhaseName']) && isset($_POST['editPhaseColor'])) {

  $phase_name = $_POST['editPhaseName'];
  $phase_color = $_POST['editPhaseColor'];





  $phase_id = $_POST['phaseIDInput'];
  $phase->changePhaseDetails($phase_name, $phase_color, $phase_id);
}

if (isset($_POST['status']) && isset($_POST['phase_id'])) {
  // var_dump($_POST['status']);
  $status = $_POST['status'];
  $phase_id = $_POST['phase_id'];
  $phase->changePhaseStatus($phase_id, $status);
}

$response = array(
  'status' => 'ok'

);
header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response);
exit; // Output the JSON response








// Check if the form is submitted
