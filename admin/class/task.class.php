<?php require_once('DAL.class.php');



class Task extends DAL
{

    public  function deleteTask($task_id)
    {
        $sql = "DELETE FROM tasks WHERE task_id=?";
        $params = ['i', $task_id];
        $this->execute($sql, $params);
    }
    public function addTask1($project_id, $start_date, $end_date)
    {
        $sql = "insert into tasks(project_id,e_start_date,e_end_date) values(?,?,?)";
        $params = ['iss', $project_id, $start_date, $end_date];

        return $this->execute($sql, $params);
    }

    public function addTask($project_id, $taskName, $start_date, $end_date)
    {
        // %d-%m-%Y

        $sql = "INSERT INTO tasks (project_id,task_name, e_start_date, e_end_date,start_date,end_date) 
                VALUES ($project_id,'$taskName', STR_TO_DATE('$start_date', '%Y-%m-%d'), STR_TO_DATE('$end_date', '%Y-%m-%d'),
                STR_TO_DATE('$start_date', '%Y-%m-%d'), STR_TO_DATE('$end_date', '%Y-%m-%d'))";

        return $this->secondExecute($sql);
    }

    public function addTaskByPhaseID($phase_id, $task_name)
    {
        $sql = "insert into tasks(phase_id,task_name) values(?,?)";
        $params = ['is', $phase_id, $task_name];
        return $this->execute($sql, $params);
    }
    function updateTask($task_id, $phase_id, $project_id, $task_name, $task_description, $task_status, $e_start_date, $e_end_date, $start_date, $end_date)
    {
        // Connect to your database


        // Prepare SQL statement
        $sql = "UPDATE tasks SET 
            --      phase_id = '$phase_id',
            -- project_id = '$project_id',
            -- task_name = '$task_name',
            -- task_description = '$task_description',
            -- task_status = '$task_status',
                e_start_date = STR_TO_DATE('$e_start_date', '%Y-%m-%d'),
            e_end_date = STR_TO_DATE('$e_end_date', '%Y-%m-%d'),
            start_date = STR_TO_DATE('$start_date', '%Y-%m-%d'),
            end_date = STR_TO_DATE('$end_date', '%Y-%m-%d')
               
                WHERE task_id = $task_id";

        // Execute SQL statement

        return $this->secondExecute($sql);
    }

    public function getTaskDetails($task_id)
    {


        $sql = "SELECT
p.phase_name,
t.task_id,
t.task_name,
t.task_description,
t.status as task_status,
t.task_priority as task_priority,
t.phase_id,
t.start_date as task_start_date,
t.end_date as task_end_date


FROM tasks AS t

LEFT JOIN phases AS p ON t.phase_id = p.phase_id




WHERE t.task_id =$task_id;
";
        return $this->getdata($sql);
    }

    public function getAllTasksByProjectId($project_id)
    {
        $sql = "SELECT * FROM tasks WHERE project_id = $project_id";

        return $this->getdata($sql);
    }

    public function getAllSubtasksByTaskID($task_id)
    {
        $sql = "SELECT * FROM subtasks
    LEFT JOIN  WHERE task_id = $task_id";

        return $this->getdata($sql);
    }

    // public function getTaskDatesBySubtaskID($subtask_id)
    // {
    //     $sql = "SELECT t.start_date,t.end_date
    //      FROM tasks as t
    //      inner join subtasks as s on s.task_id = t.task_id
    //      wheer s.subtask_id=$subtask_id;";

    //     return $this->getdata($sql);
    // }


    public function getAllSubtasksDetailsForUser($task_id, $user_id)
    {
        $sql = "SELECT * FROM subtasks 
        left join subtask_assignees as sa on sa.subtask_id=subtasks.subtask_id
        left join employees as e on e.employee_id=sa.employee_id
        where task_id = $task_id and e.user_id=$user_id";
        return $this->getdata($sql);
    }

    public function getAllSubtasksDetails($task_id)
    {
        $sql = "SELECT * FROM subtasks 
 
        where task_id = $task_id";
        return $this->getdata($sql);
    }




    



 
    public function updateTaskName($task_name, $task_id)
    {
        $sql = "UPDATE tasks SET task_name='$task_name'
    where task_id=$task_id";
       $this->execute($sql);
       

       
    }

    public function updateTaskPriority($task_priority, $task_id)
    {
        $sql = "UPDATE tasks SET task_priority='$task_priority'
    where task_id=$task_id";
        return $this->execute($sql);
    }

    public function updateTaskDescription($task_description, $task_id)
    {
        $sql = "UPDATE tasks SET task_description='$task_description'
    where task_id=$task_id";
        return $this->execute($sql);
    }


    public function updateTaskPhase($phase_id, $task_id)
    {
        $sql = "UPDATE tasks SET phase_id='$phase_id'
    where task_id=$task_id";
        return $this->execute($sql);
    }

    public function getTaskDetails_for_sidebar($task_id)
    {
        $sql = "select p.phase_name,p.due_date as phase_due_date,t.task_name,t.task_description,t.task_priority,t.status,t.due_date
        from tasks as t
        INNER JOIN phases as p on p.phase_id=t.phase_id 
        where task_id=$task_id";
        return $this->getdata($sql);
    }
}
