<?php

require('../check-login.php');
require('../../class/subtask.class.php');



$subtask = new Subtask();

if (isset($_POST['subtask_id'])) {



    $user_id = $_SESSION['user_id'];

    $subtask_id = $_POST['subtask_id'];

    // $assId = $_POST['ass_id'];


    // Check if a file is selected
    if (isset($_FILES["doc"])) {
        // $uploadDir = "C:\\xampp\\htdocs\\www\\matjar\\user\images"; // Specify the directory to save the uploaded images

        $uploadDir = "../../images/docs/";

        // Get information about the uploaded file
        $originalName = basename($_FILES["doc"]["name"]);

        $targetPath = $uploadDir . $originalName;
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);


        // Check if the file is an image
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedTypes)) {
            // if (file_exists($targetPath)) {
            //     $counter = 1;

            //     // Loop until a unique filename is found
            //     while (file_exists($targetPath)) {

            //         $targetPath = $uploadDir;
            //         $fileName = pathinfo($originalName, PATHINFO_FILENAME) . "($counter)." . pathinfo($originalName, PATHINFO_EXTENSION);
            //         $targetPath = $targetPath . $fileName;



            //         $counter++;
            //     }
            //     echo $targetPath;
            // }

            // Move the uploaded file to the specified directory
            if (!move_uploaded_file($_FILES["doc"]["tmp_name"], $targetPath)) {

                $response = array(
                    "status" => "error",
                    "message" => "error occured while uploading image file"
                );

                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
        } else {
            $response = array(
                "status" => "error",
                "message" => "Sorry, only JPG, JPEG, PNG, and GIF files are allowed."
            );

            header('Content-Type: application/json');
            echo json_encode($response);

            exit;
        }
    }


    $subtask->insertDoc($subtask_id, $user_id, $originalName);




    $response = array(
        "status" => "success"
    );

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response

    // Check if the form is submitted
}
