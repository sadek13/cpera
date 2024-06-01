<?php 
require('../check-login.php');
require('../../class/employee.class.php');


$employee = new Employee();


$division_id=$_POST['division_id'];

$filteredEmployees=$employee->getEmployeesByDivIDFullName($division_id);

header('Content-Type: application/json');

echo json_encode($filteredEmployees);
?>