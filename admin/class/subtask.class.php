<?php require_once('DAL.class.php');

class Subtask extends DAL
{


    public function insertSubTask($task_id, $subtask_name)
    {
        $currentDate = date("Y-m-d"); // Returns the current date in the format YYYY-MM-DD

        $sql = "INSERT INTO subtasks(task_id,subtask_name,due_date) VALUES($task_id, '$subtask_name','$currentDate')";

        $this->secondExecute($sql);

        $sql_task_status = "update tasks set status='In Progress' where task_id=?";
        $params = ['i', $task_id];
        $this->execute($sql_task_status, $params);
    }

    public function deleteSubTask($subtask_id)
    {
        $sql = "DELETE FROM subtasks WHERE subtask_id =?";
        $params = ['i', $subtask_id];
        return $this->execute($sql, $params);
    }
    public function updateSubTask($task_id)
    {
        //     $sql = "UPDATE subtasks set 
        //  INTO subtasks(task_id) VALUES(?)";
        //     $params = ['i', $task_id];
        //     return $this->execute($sql, $params);
    }

    public function getSubtasksDetails($task_id, $order)
    {

        $order = ($order === 'latest') ? 'DESC' : 'ASC';
        //
        $sql = "SELECT subtask_id,subtask_name,subtask_status,due_date FROM subtasks WHERE task_id=$task_id
        Order By due_date $order";
        // $params=["i",$task_id];
        return $this->getData($sql);
    }

    public function unassignEmp($ass_id, $subtask_id)
    {
        $sql = "delete from subtask_assignees where employee_id=$ass_id and subtask_id=$subtask_id";

        return $this->execute($sql);
    }

    public function insertDoc($subtask_id, $user_id, $originalName)
    {
        $sql = "insert into subtask_images(subtask_id, posted_by,image_path) value(?,?,?)";
        $params = ["iis", $subtask_id, $user_id, $originalName];
        return $this->execute($sql, $params);
    }

    public function deleteDoc($image_id)
    {
        $sql = "delete from subtask_images where image_id=?";
        $params = ['i', $image_id];
        return $this->execute($sql, $params);
    }
    public function editSubtaskStatus($subtask_status, $subtask_id)
    {
        $sql = "UPDATE subtasks SET subtask_status=?
        where subtask_id=?";

        $params = ['si', $subtask_status, $subtask_id];
        return $this->execute($sql, $params);
    }

    public function getTaskIDBySubtaskID($subtask_id,)
    {
        $sql = "Select task_id from subtasks WHERE subtask_id=$subtask_id";
        return $this->getdata($sql)[0]['task_id'];
    }



    public function getSubTaskAssigneesDetails($subtask_id)
    {
        $sql = "SELECT 
        sa.employee_id AS assignee_id,
        e.employee_fn AS assignee_fn,
        e.employee_ln AS assignee_ln,
        e.pp
    FROM 
        employees as e

    LEFT JOIN 
      subtask_assignees as sa ON sa.employee_id = e.employee_id
    WHERE 
        sa.subtask_id = $subtask_id;
 ";
        return $this->getdata($sql);
    }

    public function updateSubtaskName($subtask_id, $subtask_name)
    {
        $sql = "UPDATE subtasks 
     set subtask_name=?
     WHERE subtask_id = ?";

        $params = ['si', $subtask_name, $subtask_id];
        return $this->execute($sql, $params);
    }
    public function getSubTaskDocDetails($subtask_id)
    {
        $sql = "SELECT 
        image_path, posted_by,image_id
     FROM 
         subtask_images
 
 
     WHERE 
         subtask_id = $subtask_id;
 ";
        return $this->getdata($sql);
    }

    // public function updateSubtaskDueDate($subtask_id, $due_date)
    // {
    //     $sql = "UPDATE subtasks 
    //     SET due_date='$due_date' WHERE subtask_id =$subtask_id";

    //     return $this->secondExecute($sql);
    // }

    public function getSubtaskEnddateBySubtaskID($subtask_id)
    {
        $sql = "SELECT 
       end_date
     FROM 
       subtasks
 
 
     WHERE 
         subtask_id = $subtask_id;
 ";
        return $this->getdata($sql);
    }

    public function getSubtaskStartdateBySubtaskID($subtask_id)
    {
        $sql = "SELECT 
       satrt_date
     FROM 
       subtasks
 
 
     WHERE 
         subtask_id = $subtask_id;
 ";
        return $this->getdata($sql);
    }
    public function assignEmpToSubtask($employee_id, $subtask_id)
    {
        $sql = "insert into subtask_assignees (employee_id,subtask_id)
    values(?,?)";
        $params = ['ii', $employee_id, $subtask_id];
        return $this->execute($sql, $params);
    }


    public function getNonAssignedEmpsBySubtaskIDAndDivID($subtask_id, $division_id, $filter)
    {
        $sql = $sql = "SELECT e.employee_id, e.employee_fn, e.employee_ln, e.pp
        FROM employees AS e
        LEFT JOIN division_employees AS de ON e.employee_id = de.employee_id
        WHERE de.division_id = $division_id
          AND e.employee_id NOT IN (
            SELECT sa.employee_id
            FROM subtask_assignees AS sa
            WHERE sa.subtask_id = $subtask_id
        )
        AND (e.employee_fn LIKE '%$filter%' OR e.employee_ln LIKE '%$filter%')";

        $unAss = $this->getdata($sql);

        return $unAss;
    }
}
