<?php

require('../check-login.php');
require('../../class/project.class.php');





$project = new Project();



    $name = $_POST['projectNameInput'];

        $project->createProject($name);

        $response = array(
            'status' => 'ok'
       
        );
    

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response



// Check if the form is submitted


?>




