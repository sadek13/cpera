<?php

require('../check-login.php');
require('../../class/division.class.php');
require('../../class/employee.class.php');






$division = new Division();
$employee = new Employee();


$division_id=$_POST['currentDivID'];

 $empToDiv=$_POST['employeeToDiv'];

 foreach($empToDiv as $k=>$v){
    $employee->addEmployeeToDivision($division_id,$v);
 }




        $response = array(
            'status' => 'ok',
            'message' => 'Employee(s) Updated Successfully'
        );
    

    header('Content-Type: application/json');
    // Set the Content-Type header
    echo json_encode($response); // Output the JSON response





?>




