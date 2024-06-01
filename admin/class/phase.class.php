<?php require_once('DAL.class.php');



class Phase extends DAL
{

    public function getAllTasksDetails($phase_id, $due_date, $priority, $status)
    {
        if ($due_date != '') {
            $sql = "select * from tasks where phase_id=$phase_id order by due_date $due_date";
        } else if ($priority == 'High') {
            $sql = "SELECT * FROM tasks WHERE phase_id = $phase_id ORDER BY 
        CASE 
            WHEN task_priority = 'High' THEN 1 
            WHEN task_priority = 'Medium' THEN 2 
            WHEN task_priority = 'Low' THEN 3 
            ELSE 4 -- handle any other priorities not explicitly mentioned 
        END";
        } else if ($priority == 'Low') {
            $sql = "SELECT * FROM tasks WHERE phase_id = $phase_id ORDER BY 
        CASE 
            WHEN task_priority = 'Low' THEN 1 
            WHEN task_priority = 'Medium' THEN 2 
            WHEN task_priority = 'High' THEN 3 
            ELSE 4 -- handle any other priorities not explicitly mentioned 
        END";
        } else if ($status == 'Completed') {
            $sql = "SELECT * FROM tasks WHERE phase_id = $phase_id ORDER BY 
        CASE 
            WHEN status = 'Completed' THEN 1 
            WHEN status = 'In Progress' THEN 2 
            WHEN status = 'Unstarted' THEN 3 
            ELSE 4 -- handle any other priorities not explicitly mentioned 
        END";
        } else if ($status == 'Unstarted') {

            $sql = "SELECT * FROM tasks WHERE phase_id = $phase_id ORDER BY 
        CASE 
                  WHEN status = 'Unstarted' THEN 1 
            WHEN status = 'In Progress' THEN 2 
            WHEN status = 'Completed' THEN 3 
            ELSE 4 -- handle any other priorities not explicitly mentioned 
        END";
        }

        return $this->getdata($sql);
    }
    public function getallPhases()
    {
        $sql = 'select * from phases';
        return $this->getdata($sql);
    }



    public function changePhaseDetails($phase_name, $phase_color, $phase_id)
    {

        $sql = "update phases set phase_name=? 
,color_code=?
where phase_id=?";

        $params = ['ssi', $phase_name, $phase_color, $phase_id];

        return $this->execute($sql, $params);
    }


    public function deletePhase($phase_id)
    {

        $sql = "delete from phases 
  
    where phase_id=?";

        $params = ['i', $phase_id];

        return $this->execute($sql, $params);
    }

    public function addPhase($phase_name, $phase_color, $project_id)
    {

        $sql = "insert into phases(phase_name,color_code,project_id) values(?,?,?) ";


        $params = ['ssi', $phase_name, $phase_color, $project_id];

        return $this->execute($sql, $params);
    }
}
