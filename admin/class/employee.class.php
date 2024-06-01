<?php require_once('DAL.class.php');



class Employee extends DAL
{



    public function getAllEmployees()
    {
        $sql = "select * from employees";
        return $this->getdata($sql);
    }

    public function insertDivsion($div_name)
    {
        $sql = "insert into divisions(division_name) values(?) ";
        $params = ['s', $div_name];
        return $this->execute($sql, $params);
    }

    public function getEmployeesByDivID($div_id)
    {
        $sql = "select * from employees where division_id=$div_id";
        return $this->getdata($sql);
    }

    public function getEmployeesByDivIDFullName($div_id)
    {
        $sql = " SELECT employee_id,CONCAT(UCASE(LEFT(employee_fn, 1)), SUBSTRING(employee_fn, 2), ' ', UCASE(LEFT(employee_ln, 1)), SUBSTRING(employee_ln, 2)) AS fullname,employee_position  FROM employees 
        where division_id='$div_id'";
        return $this->getdata($sql);
    }


    public function getEmployee_DivisionName()
    {
        $sql = "SELECT e.employee_id,e.employee_fn,e.employee_ln,d.division_name, e.employee_position as position
            FROM employees e
            INNER JOIN divisions d ON d.division_id = e.division_id";

        return $this->getdata($sql);
    }

    public function registerEmployee($user_id, $employee_fn, $employee_ln, $division_id, $position, $email, $phone, $pp)
    {
        $sql = "insert into employees (user_id,employee_fn,employee_ln,division_id,employee_position,email,phone,pp)
    values(?,?,?,?,?,?,?,?)";
        $params = ['ississss', $user_id, $employee_fn, $employee_ln, $division_id, $position, $email, $phone, $pp];
        return $this->execute($sql, $params);
    }

    public function editEmployee($employee_id, $employee_fn, $employee_ln, $division_id, $position, $email, $phone, $pp)
    {
        $sql = "UPDATE employees 
            SET  employee_fn=?, employee_ln=?, division_id=?, employee_position=?, email=?, phone=? , pp=?
            WHERE employee_id=?";
        $params = ['sisssssi', $employee_fn, $employee_ln, $division_id, $position, $email, $phone, $pp, $employee_id];
        return $this->execute($sql, $params);
    }


    public function getEmployeeDetailsbyID($employee_id)
    {
        $sql = "select * from employees where employee_id=$employee_id";
        $employeeArray = $this->getdata($sql);
        $employeeRowElement = $employeeArray[0];
        return $employeeRowElement;
    }

    public function getNonDivEmps($division_id)
    {
        $sql = "SELECT e.employee_id, e.employee_fn, e.employee_ln, d.division_id, d.division_name, d.color_code 
    FROM employees e
    INNER JOIN divisions d ON d.division_ID = e.division_ID 
    WHERE d.division_id <> $division_id OR d.division_id IS NULL";


        return $this->getdata($sql);
    }

  

    public function addEmployeeToDivision($division_id, $employee_id)
    {

        $sql = "UPDATE employees 
    SET   division_id=?
    WHERE employee_id=?";
        $params = ['ii', $division_id, $employee_id];
        return $this->execute($sql, $params);
    }






    public function nameCombiner($first_name, $last_name)
    {

        $fullName = ucfirst($first_name) . ' ' . ucfirst($last_name[0]) . '.';

        // Output the result
        return  $fullName;
    }

    public function validateEmail($email)
    {
        // Use the FILTER_VALIDATE_EMAIL filter
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => 'error',
                'message' => "Invalid input. Wrong Email Address Fomrat.",
            ));
            exit;
        }
    }

    public function getIDImagesByEmployeeID($employee_id)
    {
        $sql = "select * from employee_idimage where employee_id=$employee_id";
        $idImagesArray = $this->getdata($sql);
        if (!empty($idImagesArray)) {
            $idImagesElement = $idImagesArray[0];
        } else {
            $idImagesElement = 'needs to be updated maybe';
        }
        return $idImagesElement;
    }
}
