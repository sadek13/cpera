<?php

require('../check-login.php');
require('../../class/user.class.php');
require('../../class/admin.class.php');






$user = new User();
$admin = new Admin();




if ($_POST) {


    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin_fn = $_POST['admin_fn'];
    $admin_ln = $_POST["admin_ln"];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user->validate('post');

        $user->validateUserName($username);





        // Check if a file is selected
        if (isset($_FILES["pp"])) {
            // $uploadDir = "C:\\xampp\\htdocs\\www\\matjar\\user\images"; // Specify the directory to save the uploaded images
            $pp = $_FILES['pp']['name'];

            $uploadDir = "../images/pp/";

            // Get information about the uploaded file
            $originalName = basename($_FILES["pp"]["name"]);

            $targetPath = $uploadDir . $originalName;
            $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);


            // Check if the file is an image
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            if (in_array($fileType, $allowedTypes)) {
                if (file_exists($targetPath)) {
                    $counter = 1;

                    // Loop until a unique filename is found
                    while (file_exists($targetPath)) {

                        $targetPath = $uploadDir;
                        $fileName = pathinfo($originalName, PATHINFO_FILENAME) . "($counter)." . pathinfo($originalName, PATHINFO_EXTENSION);
                        $targetPath = $targetPath . $fileName;



                        $counter++;
                    }
                    echo $targetPath;
                }

                // Move the uploaded file to the specified directory
                if (!move_uploaded_file($_FILES["prodImg"]["tmp_name"], $targetPath)) {

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
    }


    //    $user->validatePhoneNumber($phone);


    $user_id = $user->registerUser($username, "admin", $password);
    $admin->registerAdmin($admin_fn, $admin_ln, $user_id);







    $response = array(
        'status' => 'ok',
        'message' => 'New Admin Added'
    );
}

header('Content-Type: application/json');
// Set the Content-Type header
echo json_encode($response); // Output the JSON response



// Check if the form is submitted
