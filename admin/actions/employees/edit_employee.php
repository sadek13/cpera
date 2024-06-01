<?php

require('../check-login.php');
require('../../class/user.class.php');
require('../../class/employee.class.php');





$user = new User();
$employee = new Employee();




if ($_POST) {
   
    $fn=$_POST['first-name'];
$ln=$_POST['last-name'];
   $phone=$_POST['phone'];
   $email=$_POST['email'];
   $position=$_POST['employee_position'];
   $division_id=$_POST['division_id'];
$employee_id=$_POST['employee_id'];


   $username=$_POST['username'];  
   $password=$_POST['password'] ;


//    $user->validate('post');


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is selected
    if (isset($_FILES["pp"])) {
        // $uploadDir = "C:\\xampp\\htdocs\\www\\matjar\\user\images"; // Specify the directory to save the uploaded images
        $image=$_FILES['pp']['name'];

        $uploadDir = "../../images/";

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
          
                    $targetPath=$uploadDir;
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME) . "($counter)." . pathinfo($originalName, PATHINFO_EXTENSION);
                    $targetPath=$targetPath . $fileName;

            

                    $counter++;
                   

                }
                echo $targetPath;
            }
            
            // Move the uploaded file to the specified directory
            if (!move_uploaded_file($_FILES["prodImg"]["tmp_name"], $targetPath)) {
                $response=array(
                    "status"=> "error",
                    "message"=> "error occured while uploading image file"
                );
                echo json_encode($response);
                exit;
            } 
        } else {
                 $response=array(
                    "status"=> "error",
                    "message"=> "Sorry, only JPG, JPEG, PNG, and GIF files are allowed."
                );
                echo json_encode($response);

            exit;
        }
    } 
}



$user->validatePhoneNumber($phone);


$employee->validateEmail($email);


 $employee->editEmployee($employee_id,$fn,$ln,$division_id,$position,$email,$phone,'');






        $response = array(
            'status' => 'ok',
            'message' => 'Employee Info Updated Successfully'
        );
    }

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response





?>




