<?php require_once('DAL.class.php');



class Division extends DAL
{



    public function getAllDivisions()
    {
        $sql = "select * from divisions";
        return $this->getdata($sql);
    }

    public function getDivisionID()
    {
        $sql = "select division_id from divisions";
        $allDivsIDsArray = $this->getdata($sql);
        $divID = $allDivsIDsArray[0]["division_id"];
        return $divID;
    }

    public function getDivisionDetailsByID($division_id)
    {

        $sql = "select * from divisions where division_id=$division_id";
        $divArray = $this->getdata($sql);
        return $divArray[0];
    }


    // public function getMembersByDivName($division_name,$project_id){

    //     $sql="SELECT e.employee_id, e.employee_fn, e.employee_ln, e.pp 
    //     FROM division_employees AS de 
    //     INNER JOIN employees AS e ON e.employee_id = de.employee_id 
    //     INNER JOIN users AS u ON u.user_id = e.user_id 
    //     INNER JOIN project_managers AS pm ON pm.user_id = u.user_id 
    //     INNER JOIN divisions AS d ON d.division_id = de.division_id 
    //     WHERE d.division_name = '$division_name' and pm.project_id <> $project_id;

    //     ";


    //      return $this->getdata($sql);
    // }

    public function getMembersByDivName($division_name, $project_id)
    {

        $sql = "SELECT e.employee_id, e.employee_fn, e.employee_ln, e.pp 
        FROM division_employees AS de 
        INNER JOIN employees AS e ON e.employee_id = de.employee_id 
    
        INNER JOIN divisions AS d ON d.division_id = de.division_id 
        WHERE d.division_name = '$division_name'
        
        ";


        return $this->getdata($sql);
    }



    public function isPM($user_id)
    {

        $sql = "SELECT COUNT(*) 
        FROM division_employees AS de
        INNER JOIN divisions AS d ON d.division_id = de.division_id 
        INNER JOIN employees AS e ON de.employee_id = e.employee_id 
        WHERE d.division_name = 'project management' 
        AND e.user_id = $user_id;
        
        ";


        return $this->getdata($sql);
    }


    public function insertDivsion($div_name, $color_code)
    {
        $sql = "insert into divisions(division_name,color_code) values(?,?) ";
        $params = ['ss', $div_name, $color_code];
        return $this->execute($sql, $params);
    }

    public function updateDivsion($div_name, $div_id, $color_code)
    {
        $sql = "UPDATE divisions
        SET division_name = ?,color_code =?
        WHERE division_id = ?";

        $params = ['ssi', $div_name, $color_code, $div_id];  // Assuming $div_id is the division_id you want to update

        return $this->execute($sql, $params);
    }

    public function deleteDivision($division_id)
    {
        $sql = "delete  from divisions where division_id =?";
        $params = ['i', $division_id];
        return $this->execute($sql, $params);
    }
}
