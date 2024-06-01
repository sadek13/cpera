<?php require_once('DAL.class.php');


class Project extends DAL
{


    public function createProject($project_name)
    {
        $sql = "insert into projects(project_name) values(?);";
        $params = ['s', $project_name];
        return $this->execute($sql, $params);
    }

    public function deleteProject($project_id)
    {
        $sql = "delete from projects where project_id=?";
        $params = ['i', $project_id];
        $this->execute($sql, $params);
    }
    public function getAllProjectsDetails($due_date_sort, $completion_filter)
    {
        $sql = "select project_id,project_name,status,due_date from projects order by due_date $due_date_sort";

        $details = $this->getdata($sql);


        if ($completion_filter == 'true') {
            $sql = "select project_id,project_name,status,due_date from projects where status='Completed'";
            $details = $this->getdata($sql);
        } else if ($completion_filter == 'false') {

            $sql = "select project_id,project_name,status,due_date from projects where status != 'Completed'";
            $details = $this->getdata($sql);
        }


        if ($due_date_sort)
            foreach ($details as &$sub) {
                $project_id = $sub['project_id'];
                $percentage = $this->getProjectPercentage($project_id);
                $sub['percentage'] = $percentage;
            }
        unset($sub);
        return $details;
    }

    public function getAllProjectsDetailsForUser($user_id, $due_date_sort, $completion_filter)
    {
        $sql = "select p.project_name,p.project_id,p.status,p.due_date from projects as p
        left join tasks as t on t.project_id = p.project_id
        left join subtasks as st on st.task_id = t.task_id
        left join subtask_assignees as sa on sa.subtask_id = st.subtask_id
        left join employees as e on e.employee_id=sa.employee_id
        where e.user_id=$user_id";

        $details = $this->getdata($sql);

        foreach ($details as &$sub) {
            $project_id = $sub['project_id'];
            $percentage = $this->getProjectPercentage($project_id);
            $sub['percentage'] = $percentage;
        }

        return $details;
    }


    public function getAllProjectsDetailsForPM($user_id, $due_date_sort, $completion_filter)
    {

        $sql = "select p.project_name,p.project_id,p.status,p.due_date from projects as p
inner join project_managers as pm on pm.project_id = p.project_id
where pm.user_id = $user_id order by p.due_date $due_date_sort";
        $details = $this->getdata($sql);

        if ($completion_filter == 'true') {
            $sql = "select p.project_name,p.project_id,p.status,p.due_date from projects as p
        inner join project_managers as pm on pm.project_id = p.project_id
        where pm.user_id = $user_id and p.status='Completed'";
            $details = $this->getdata($sql);
        } else if ($completion_filter == 'false') {


            $sql = "SELECT p.project_name, p.project_id, p.status, p.due_date 
                FROM projects AS p
               LEFT JOIN project_managers AS pm ON pm.project_id = p.project_id
                WHERE pm.user_id = $user_id AND p.status != 'Completed'";
            $details = $this->getdata($sql);
        }

        foreach ($details as &$sub) {
            $project_id = $sub['project_id'];
            $percentage = $this->getProjectPercentage($project_id);
            $sub['percentage'] = $percentage;
        }

        return $details;
    }
    public function getAllProjects()
    {
        $sql = "SELECT * from projects";

        return $this->getdata($sql);
    }


    public function getProjectPercentage($project_ID)
    {
        // Count completed tasks
        $sql_completed = "SELECT COUNT(*) as completed_count FROM phases WHERE project_id = $project_ID AND status = 'completed'";
        $completed_result = $this->getData($sql_completed);


        // var_dump($project_ID);

        // Count all tasks
        $sql_all = "SELECT COUNT(*) as total_count FROM phases WHERE project_id = $project_ID";
        $all_result = $this->getData($sql_all);

        // var_dump($all_result);


        // Check for errors in database queries (assuming you have appropriate error handling in getData)
        if (!$completed_result || !$all_result) {
            return false; // Return an error or handle it appropriately
        }

        // Fetch the count values
        $completed_count = $completed_result[0]['completed_count'];
        $total_count = $all_result[0]['total_count'];



        // Calculate the percentage (avoid division by zero)
        if ($total_count > 0) {
            $percentage = ($completed_count / $total_count) * 100;
        } else {
            $percentage = 0;
        }

        return $percentage;
    }



    public function getProjectName($project_id)
    {
        $sql = "SELECT project_name FROM projects WHERE project_id=$project_id";

        $row = $this->getdata($sql)[0];
        $project_name = ucwords($row['project_name']);
        return $project_name;
    }


    public function getAProjectID()
    {
        $sql = "SELECT project_id from projects";


        $projectIDSArray = $this->getdata($sql);
        $projectID = $projectIDSArray[0];
        return $projectID;
    }




    public function getProjectPercentageArray()
    {
        $percentageArray = array();
        $allProjects = $this->getAllProjects();

        foreach ($allProjects as $k => $v) {

            $projectID = $v['project_id'];

            $percentage = $this->getProjectPercentage($projectID);

            $percentageArray[$projectID] = $percentage;
        }
        return json_encode($percentageArray);
    }

    public function getProjectDetails($project_id)
    {
        $sql = "SELECT p.project_id,p.project_name,p.project_description,p.status,p.due_date
        FROM projects p
        where project_id=$project_id";
        return $this->getdata($sql);
    }

    public function getProjectPhasesByProjectID($project_id)
    {
        $sql = "SELECT phase_id,phase_name,color_code,due_date,status as phase_status
        FROM phases
        where project_id=$project_id";
        return $this->getdata($sql);
    }

    public function addProjectManager($e_id, $project_id)
    {

        $sql_user_id = "select user_id from employees where employee_id=$e_id";
        $user_id = $this->getdata($sql_user_id)[0]['user_id'];

        $sql_search = "select COUNT(*) from project_managers where user_id=$user_id
        and project_id=$project_id";


        $existing_manager = $this->getData($sql_search);

        // If the user is already a project manager for the given project, return false
        if ($existing_manager[0]['COUNT(*)'] > 0) {
            return false;
        }




        $sql_insert = "INSERT INTO project_managers(project_id, user_id) values(?,?)";
        $params = ['ii', $project_id, $user_id];
        $this->execute($sql_insert, $params);
        return true;
    }

    public function removeProjectManager($user_id)
    {
        $sql = "delete from project_managers where user_id=?";
        $params = ['i', $user_id];
        $this->execute($sql, $params);
    }


    public function getPhasePercentage($phase_id)
    {
        $tasks_sql = "SELECT COUNT(task_id) as tasks FROM tasks WHERE phase_id =$phase_id";
        $tasks = $this->getdata($tasks_sql);


        // Query to get the number of completed tasks for the given phase
        $c_tasks_sql = "SELECT COUNT(task_id) as Completed FROM tasks WHERE phase_id = $phase_id AND status = 'Completed'";
        $c_tasks = $this->getdata($c_tasks_sql);

        if ($tasks[0]['tasks'] != 0)
            return round(($c_tasks[0]['Completed'] / $tasks[0]['tasks']) * 100);

        else
            return 0;
    }

    public function getProjectManagersByProjectID($project_id)
    {
        $sql = "SELECT pm.user_id, e.employee_fn, e.employee_ln, a.admin_fn, a.admin_ln
        FROM project_managers pm
        LEFT JOIN employees e ON pm.user_id = e.user_id 
        
        LEFT JOIN `admin` a ON pm.user_id = a.user_id
   AND pm.project_id = $project_id";


        return $this->getdata($sql);
        // $params=["i",$project_id];
        // return $this->data($sql,$params);
    }
    public function changeProjectDesc($project_desc, $project_id)
    {
        $sql = "Update projects SET project_description=? WHERE project_id=?";
        $params = ["si", $project_desc, $project_id];
        return $this->execute($sql, $params);
    }
    public function changeProjectName($project_name, $project_id)
    {
        $sql = "Update projects SET project_name=? WHERE project_id=?";
        $params = ["si", $project_name, $project_id];
        return $this->execute($sql, $params);
    }
    public function getAllTasksDetails($project_id)
    {

        $sql = "SELECT 
        e.pp AS employee_pp,
        p.phase_name,
        p.color_code,   
        t.task_id,
        t.task_name,
        t.status AS task_status,
        t.phase_id,
        t.task_priority AS task_priority,
        t.start_date as task_start_date,
        t.end_date as task_end_date,
        t.due_date,
        pr.project_name
  
 FROM tasks AS t
 LEFT JOIN projects AS pr ON pr.project_id = t.project_id

 LEFT JOIN phases AS p ON t.phase_id = p.phase_id
 LEFT JOIN subtasks AS s ON t.task_id = s.task_id
 LEFT JOIN subtask_assignees as sa ON s.subtask_id=sa.subtask_id 
 LEFT JOIN users AS u ON sa.assigned_user_id = u.user_id
 
 
 LEFT JOIN employees AS e ON u.user_id = e.employee_id 
 WHERE t.project_id =$project_id;
 ";
        return $this->getdata($sql);
    }


    public function getAllPhasesDetails($project_id)
    {
        $sql = "select * from phases where project_id=$project_id";
        return $this->getdata($sql);
    }

    public function getAllProjectsDetailsForUserListView($user_id)
    {
        $sql = "select p.project_id,p.project_name,p.due_date,p.status from projects as p
        
        left join tasks as t on t.project_id = p.project_id
        left join subtasks as st on st.task_id = t.task_id
        left join subtask_assignees as sa on sa.subtask_id = st.subtask_id
        left join employees as e on e.employee_id=sa.employee_id
        where e.user_id=$user_id";

        return $this->getdata($sql);
    }

    public function getAProjectDetailsForUserListView($user_id, $project_id)
    {
        $sql = "select ph.phase_id,ph.phase_name,p.project_id,p.project_name from phases as ph
        left join projects as p ON ph.project_id = p.project_id
        left join tasks as t on t.phase_id = ph.phase_id
        left join subtasks as st on st.task_id = t.task_id
        left join subtask_assignees as sa on sa.subtask_id = st.subtask_id
        left join employees as e on e.employee_id=sa.employee_id
        where e.user_id=$user_id and p.project_id=$project_id";

        return $this->getdata($sql);
    }
}
