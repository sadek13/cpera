<?php
class DAL
{
  public $servername = "localhost";
  public $username = "root";
  public $password = "";
  public $dbname = "cpera";

  public function validatePhoneNumber($phone)
  {
    $phone = preg_replace('/[\/ ]/', '', $phone);
    $pattern = '/^(?:\+?\d{1,3})?[ -]?\(?\d{3}\)?[ -]?[0-9]{3}[ -]?[0-9]{4}$/';
    $pattern2 = '/^\+?[1-9][0-9]{7,14}$/';
    if (preg_match($pattern, $phone) || preg_match($pattern2, $phone)) {
      return $phone;
    } else {
      header('Content-Type: application/json');
      echo json_encode(array(
        'status' => 'error',
        'message' => "Invalid input. Wrong Phone Number Fomrat.",
      ));
      exit();
    }
  }










  public function have_script($value)
  {
    $patterns = array(
      '/<script>/i',
      '/<script src="">/i',
      '/<\/script>/i',
      '/<\?php/i',
      '/<\?/i',
      '/exec\(/i',
      '/system\(/i',
      '/passthru\(/i'
      // Add more patterns as needed
    );
    foreach ($patterns as $pattern) {
      if (preg_match($pattern, $value, $matches)) {
        return $matches[0]; // Return the matched script type
      }
    };
  }

  public function  validate($method)
  {
    if ($method == "post") {

      foreach ($_POST as $k => $v) {
        if (gettype($_POST["$k"]) == "array") {

          foreach ($_POST["$k"] as $k1 => $v1) {

            $scriptType = $this->have_script($v1);
            if ($scriptType) {

              $_POST["$k"]["$k1"] = " ";
              header('Content-Type: application/json');
              echo json_encode(array(
                'status' => 'error',
                'message' => "Invalid input. Detected unsupported formats in input;"
              ));
              exit(); // Stop further execution
            }
          }
        } else {
          $scriptType = $this->have_script($v);
          if ($scriptType) {

            $_POST["$k"] = " ";
            header('Content-Type: application/json');
            echo json_encode(array(
              'status' => 'error',
              'message' => "Invalid input. Detected unsupported formats in input."
            ));
            exit(); // Stop further execution
          }
        }
      }
    } else if ($method == "get") {
      foreach ($_GET as $k => $v) {
        if (gettype($_GET["$k"]) == "array") {
          foreach ($_GET["$k"] as $k1 => $v1) {
            $scriptType = $this->have_script($v1);
            if ($scriptType) {
              $_GET["$k"]["$k1"] = " ";
              header('Content-Type: application/json');
              echo json_encode(array(
                'status' => 'error',
                'message' => "Invalid input. Detected unsupported formats in input."
              ));
              exit(); // Stop further execution
            }
          }
        } else {
          $scriptType = $this->have_script($v);
          if ($scriptType) {
            $_GET["$k"] = " ";
            header('Content-Type: application/json');
            echo json_encode(array(
              'status' => 'error',
              'message' => "Invalid input. Detected unsupported formats in input;"
            ));
            exit(); // Stop further execution
          }
        }
      }
    }
  }

  public function getdata($sql)
  {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($conn->connect_error) {
      throw new Exception($conn->connect_error);
      // die("Connection failed: " . $conn->connect_error);
    } else {
      $result = $conn->query($sql);
      if (!$result) {
        throw new Exception($conn->error);
      } else {
        $result = $conn->query($sql);
        $results = $result->fetch_all(MYSQLI_ASSOC);
        return $results;
      }
    }
  }

  // public function insertData($sql)
  // {
  //   $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  //   if ($conn->connect_error) {
  //     throw new Exception($conn->connect_error);
  //     // die("Connection failed: " . $conn->connect_error);
  //   } else {

  //     if(!$result = $conn->query($sql)){
  //       //throw new Exception($conn->connect_error);
  //     }








  // }



  public function ConnectionDatabase()
  {
    return new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  }



  public function execute($sql, $params = [])
  {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($conn->connect_error) {
      throw new Exception($conn->connect_error);
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      throw new Exception($conn->error);
    }

    if (!empty($params)) {
      $stmt->bind_param(...$params);
    }

    if (!$stmt->execute()) {
      throw new Exception($stmt->error);
    }

    return $stmt->insert_id;
  }

  public function secondExecute($sql)
  {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($conn->connect_error) {
      throw new Exception($conn->connect_error);
    }
    return $conn->query($sql);
  }

  public function delete($sql, $params = [])
  {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($conn->connect_error) {
      throw new Exception($conn->connect_error);
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      throw new Exception($conn->error);
    }

    if (!empty($params)) {
      $stmt->bind_param(...$params);
    }

    if (!$stmt->execute()) {
      throw new Exception($stmt->error);
    }

    $stmt->close();
    $conn->close();
    return true;
  }


  public function data($sql, $params = array())
  {
    $conn = $this->ConnectionDatabase();

    // Check if there are parameters
    if (!empty($params)) {
      $stmt = $conn->prepare($sql);

      if ($stmt === false) {
        throw new Exception($conn->error);
      }

      $types = str_repeat('s', count($params));
      $stmt->bind_param($types, ...$params);

      $result = $stmt->execute();

      if ($result === false) {
        throw new Exception($stmt->error);
      }

      $resultSet = $stmt->get_result();
      $results = $resultSet->fetch_all(MYSQLI_ASSOC);

      $stmt->close();
    } else {
      // If there are no parameters, execute the query directly
      $result = $conn->query($sql);

      if ($result === false) {
        throw new Exception($conn->error);
      }

      $results = $result->fetch_all(MYSQLI_ASSOC);
    }

    $conn->close();

    return $results;
  }








  public function getTaskDueDateBySubtaskID($subtask_id)
  {

    $query = "SELECT tasks.due_date
  FROM subtasks
  INNER JOIN tasks ON subtasks.task_id = tasks.task_id
  WHERE subtasks.subtask_id = $subtask_id";

    return $this->getdata($query)[0]['due_date'];
  }

  //   public function getSubtaskDueDateBySubtaskID($subtask_id)
  //   {
  //     $sql = "SELECT due_date
  //        FROM subtasks 
  // Where subtask_id = $subtask_id";
  //     $due_date = $this->getdata($sql)[0]['due_date'];
  //     return $due_date;
  //   }


  // public function updateSubtaskDueDateBySubtaskID($subtask_id, $new_date3)
  // {


  //   $task_due_date = $this->getTaskDueDateBySubtaskID($subtask_id);

  //   echo 'subtask new' . $new_date3;
  //   echo 'task due date' . $task_due_date;

  //   if ($task_due_date < $new_date3) {

  //     return false;
  //   } else {

  //     $sqlUpdateSubtask = "UPDATE subtasks SET due_date=? WHERE subtask_id=?";
  //     $paramsUpdateSubtask = ['si', $new_date3, $subtask_id];
  //     $this->execute($sqlUpdateSubtask, $paramsUpdateSubtask);


  //     return true;
  //   }
  // }





  public function updateSubtaskDueDateBySubtaskID($subtask_id, $new_date3)
  {


    $task_due_date = $this->getTaskDueDateBySubtaskID($subtask_id);



    if ($task_due_date < $new_date3) {

      return false;
    } else {

      $sqlUpdateSubtask = "UPDATE subtasks SET due_date=? WHERE subtask_id=?";
      $paramsUpdateSubtask = ['si', $new_date3, $subtask_id];
      $this->execute($sqlUpdateSubtask, $paramsUpdateSubtask);


      return true;
    }
  }

  public function updateSubtaskDueDateBySubtaskID_ByTaskUpdate($subtask_id, $new_date3)
  {

    // echo 'subtask new' . $new_date3;

    $sqlUpdateSubtask = "UPDATE subtasks SET due_date=? WHERE subtask_id=?";
    $paramsUpdateSubtask = ['si', $new_date3, $subtask_id];
    $this->execute($sqlUpdateSubtask, $paramsUpdateSubtask);


    return true;
  }


  //Tasks due date control

  public function getAllSubtasksDueDateBytaskID($task_id)
  {
    $sql = "select subtask_id,due_date from subtasks where task_id = $task_id";
    return $this->getdata($sql);
  }





  public function getPhaseDueDateByTaskID($task_id)
  {

    $query = "SELECT phases.due_date
  FROM tasks
  INNER JOIN phases ON tasks.phase_id = phases.phase_id
  WHERE tasks.task_id = $task_id";

    return $this->getdata($query)[0]['due_date'];
  }

  public function getTaskDueDateByTaskID($task_id)
  {
    $sql = "SELECT due_date
       FROM tasks 
Where task_id = $task_id";
    $due_date = $this->getdata($sql)[0]['due_date'];
    return $due_date;
  }





  public function updateTaskDueDateByTaskID($task_id, $new_date2)
  {

    $phase_due_date = $this->getPhaseDueDateByTaskID($task_id);


    if ($phase_due_date < $new_date2) {

      return false;
    } else {
      $old_date2 = $this->getTaskDueDateByTaskID($task_id);

      $currentDate = date("Y-m-d");
      $dueDiff2 = strtotime($new_date2) - strtotime($old_date2);

      $subs = $this->getAllSubtasksDueDateBytaskID($task_id);

      // echo 'task new' . $new_date2;

      // echo 'task old' . $old_date2;

      $sqlUpdateTask = "UPDATE tasks SET due_date=? WHERE task_id=?";
      $paramsUpdateTask = ['si', $new_date2, $task_id];
      $this->execute($sqlUpdateTask, $paramsUpdateTask);

      foreach ($subs as $sub) {
        $subtask_id = $sub['subtask_id'];
        $sub_old_date = strtotime($sub['due_date']);
        $sub_new_date = date("Y-m-d", $sub_old_date + $dueDiff2);



        if ($sub_new_date < $currentDate) {

          $sub_new_date = $currentDate;
        }

        $this->updateSubtaskDueDateBySubtaskID_ByTaskUpdate($subtask_id, $sub_new_date);
      }


      return true;
    }
  }


  public function updateTaskDueDateByTaskID_ByPhaseUpdate($task_id, $new_date2)
  {



    $old_date2 = $this->getTaskDueDateByTaskID($task_id);

    $currentDate = date("Y-m-d");
    $dueDiff2 = strtotime($new_date2) - strtotime($old_date2);

    $subs = $this->getAllSubtasksDueDateBytaskID($task_id);

    // echo 'task new' . $new_date2;

    // echo 'task old' . $old_date2;

    $sqlUpdateTask = "UPDATE tasks SET due_date=? WHERE task_id=?";
    $paramsUpdateTask = ['si', $new_date2, $task_id];
    $this->execute($sqlUpdateTask, $paramsUpdateTask);

    foreach ($subs as $sub) {
      $subtask_id = $sub['subtask_id'];
      $sub_old_date = strtotime($sub['due_date']);
      $sub_new_date = date("Y-m-d", $sub_old_date + $dueDiff2);



      if ($sub_new_date < $currentDate) {

        $sub_new_date = $currentDate;
      }

      $this->updateSubtaskDueDateBySubtaskID_ByTaskUpdate($subtask_id, $sub_new_date);
    }


    return true;
  }




  //Phases Due Dates Control


  public function getProjectDueDateByPhaseID($phase_id)
  {
    $sql = "select p.due_date from projects as p
  inner join phases as ph on ph.project_id=p.project_id
  where ph.phase_id=$phase_id";

    return $this->getdata($sql)[0]['due_date'];
  }


  public function getPhaseDueDateByPhaseID($phase_id)
  {
    $sql = "select due_date from phases
  where phase_id=$phase_id";
    return $this->getdata($sql)[0]['due_date'];
  }

  public function getAllTasksDueDateByPhaseID($phase_id)
  {
    $sql = "Select task_id,due_date from tasks where phase_id=$phase_id";
    return $this->getdata($sql);
  }

  public function updatePhaseDueDateByPhaseID($phase_id, $new_date1)
  {

    $project_due_date = $this->getProjectDueDateByPhaseID($phase_id);


    // echo 'pr' .$project_due_date;
    // echo $new_date1;

    if ($project_due_date < $new_date1) {

      return false;
    } else {
      $old_date1 = $this->getPhaseDueDateByPhaseID($phase_id);




      $dueDiff1 = strtotime($new_date1) - strtotime($old_date1);

      // echo 'phase new' . $new_date1;

      // echo 'phase old' . $old_date1;

      $subs = $this->getAllTasksDueDateByPhaseID($phase_id);

      $currentDate = date("Y-m-d");

      $sqlUpdatePhase = "UPDATE phases SET due_date=? WHERE phase_id=?";
      $paramsUpdatePhase = ['si', $new_date1, $phase_id];
      $this->execute($sqlUpdatePhase, $paramsUpdatePhase);


      foreach ($subs as $sub) {

        $task_id = $sub['task_id'];
        $sub_old_date = strtotime($sub['due_date']);
        $sub_new_date = date("Y-m-d", $sub_old_date + $dueDiff1);




        if ($sub_new_date < $currentDate) {

          $sub_new_date = $currentDate;
        }


        $this->updateTaskDueDateByTaskID_ByPhaseUpdate($task_id, $sub_new_date);
      }
      $subs = $this->getAllTasksDueDateByPhaseID($phase_id);


      return true;
    }
  }










  public function updatePhaseDueDateByPhaseID_ByProjectUpdate($phase_id, $new_date1)
  {



    // echo 'phase_new' . $new_date1;


    $old_date1 = $this->getPhaseDueDateByPhaseID($phase_id);




    $dueDiff1 = strtotime($new_date1) - strtotime($old_date1);

    // echo 'phase new' . $new_date1;

    // echo 'phase old' . $old_date1;

    $subs = $this->getAllTasksDueDateByPhaseID($phase_id);

    $currentDate = date("Y-m-d");

    $sqlUpdatePhase = "UPDATE phases SET due_date=? WHERE phase_id=?";
    $paramsUpdatePhase = ['si', $new_date1, $phase_id];
    $this->execute($sqlUpdatePhase, $paramsUpdatePhase);


    foreach ($subs as $sub) {

      $task_id = $sub['task_id'];
      $sub_old_date = strtotime($sub['due_date']);
      $sub_new_date = date("Y-m-d", $sub_old_date + $dueDiff1);




      if ($sub_new_date < $currentDate) {

        $sub_new_date = $currentDate;
      }


      $this->updateTaskDueDateByTaskID_ByPhaseUpdate($task_id, $sub_new_date);
    }
    $subs = $this->getAllTasksDueDateByPhaseID($phase_id);


    return true;
  }




  //Project due date control







  public function getProjectDueDateByProjectID($project_id)
  {
    $sql = "select due_date from projects
  where project_id=$project_id";
    return $this->getdata($sql)[0]['due_date'];
  }

  public function getAllPhasesDueDateByProjectID($project_id)
  {
    $sql = "Select phase_id,due_date from phases where project_id=$project_id";
    return $this->getdata($sql);
  }




  public function checkTasksIfComplete($task_id)
  {
    echo $task_id;
    $sql_find_id = "select phase_id from tasks where task_id=$task_id";
    $phase_id = $this->getdata($sql_find_id)[0]['phase_id'];

    $sql_all_tasks = "select status from tasks where phase_id=$phase_id";
    $all_tasks = $this->getdata($sql_all_tasks);

    $sql_ip = "update phases set status='Completed' where phase_id=?";

    foreach ($all_tasks as $task) {
      if ($task['status'] != 'Completed') {
        $sql_ip = "update phases set status='In Progress' where phase_id=?";
      }
    }
    $params = ['i', $phase_id];
    $this->execute($sql_ip, $params);
  }


  public function checkSubtasksIfCompleted($task_id)
  {

    $sql_subtasks = "SELECT subtask_status FROM subtasks where task_id = $task_id";
    $subtasks = $this->getdata($sql_subtasks);
    foreach ($subtasks as $subtask) {
      if ($subtask['subtask_status'] != 'Completed') {
        return false;
      }
    }
    return true;
  }

  public function changeTaskStatusbySubtasksStatuses($task_id)
  {
    $isCompleted = $this->checkSubtasksIfCompleted($task_id);
    if ($isCompleted) {
      $sql = "update tasks set status='Completed' where task_id=?";
      $params = ['i', $task_id];
      $this->execute($sql, $params);
      $this->ChangePhasesStatusByTaskStatuses($task_id);
    } else {
      $sql = "update tasks set status='In Progress' where task_id=?";
      $params = ['i', $task_id];
      $this->execute($sql, $params);
    }
  }

  public function ChangePhasesStatusByTaskStatuses($task_id)
  {

    $sql_phase_id = "select phase_id from tasks where task_id=$task_id";
    $phase_id = $this->getdata($sql_phase_id)[0]['phase_id'];


    $sql = "select status from tasks where phase_id = $phase_id";
    $tasks = $this->getdata($sql);

    $sql_phase = "update phases set status = 'Completed' where phase_id=?";

    foreach ($tasks as $task) {
      if ($task['status'] != 'Completed') {

        $sql_phase = "update phases set status = 'In Progress' where phase_id=?";
      }
      // echo $task['status'];
    }
    $params = ['i', $phase_id];
    $this->execute($sql_phase, $params);
    $this->ChangeProjectStatusByPhaseStatus($phase_id);
  }


  public function ChangeProjectStatusByPhaseStatus($phase_id)
  {

    $sql_project_id = "select project_id from phases where phase_id=$phase_id";
    $project_id = $this->getdata($sql_project_id)[0]['project_id'];


    $sql = "select status from phases where project_id = $project_id";
    $phases = $this->getdata($sql);

    $sql_projects = "update projects set status = 'Completed' where project_id=?";

    foreach ($phases as $phase) {
      if ($phase['status'] != 'Completed') {

        $sql_projects = "update projects set status = 'On Track' where project_id=?";
      }
      // echo $task['status'];
    }
    $params = ['i', $project_id];
    $this->execute($sql_projects, $params);
  }

  public function changeProjectStatus($status, $project_id)
  {

    $sql = "update projects set status=?
      WHERE project_id=?";
    $params = ['si', $status, $project_id];
    $this->execute($sql, $params);


    if ($status == 'Completed') {

      $sql_all_phases = "select phase_id from phases where project_id=$project_id";
      $all_phases = $this->getdata($sql_all_phases);

      foreach ($all_phases as $phase) {

        $phase_id = $phase['phase_id'];
        $this->changePhaseStatus($phase_id, 'Completed');
      }
    }
  }

  public function changePhaseStatus($phase_id, $status)
  {

    $sql_phase = "update phases set status = ? where phase_id=?";
    $params = ['si', $status, $phase_id];
    $this->execute($sql_phase, $params);
    $this->ChangeProjectStatusByPhaseStatus($phase_id);

    if ($status == 'Completed') {
      $sql_all_tasks = "select task_id from tasks where phase_id=$phase_id";
      $all_tasks = $this->getdata($sql_all_tasks);

      foreach ($all_tasks as $task) {

        $task_id = $task['task_id'];
        $this->updateTaskStatus('Completed', $task_id);
      }
    }
  }

  public function updateTaskStatus($task_status, $task_id)
  {
    $sql = "UPDATE tasks SET status='$task_status'
  where task_id=$task_id";
    $this->execute($sql);

    $this->changeAllSubtasksToCompleted($task_id); //
    $this->ChangePhasesStatusByTaskStatuses($task_id);
  }



  public function changeAllSubtasksToCompleted($task_id)
  {
    // foreach ($subtasks as $subtask) {
    //     $subtask_id=$subtask['subtask_id'];
    $sql_update = "update subtasks set subtask_status='Completed' where task_id=?";
    $params = ['i', $task_id];
    $this->execute($sql_update, $params);
  }


  public function updateProjectDueDateByProjectID($project_id, $new_date)
  {




    $old_date = $this->getProjectDueDateByProjectID($project_id);




    $dueDiff = strtotime($new_date) - strtotime($old_date);


    $subs = $this->getAllPhasesDueDateByProjectID($project_id);


    $currentDate = date("Y-m-d");

    // echo 'project new' . $new_date;
    // echo 'project old' . $old_date;

    $sqlUpdateProject = "UPDATE projects SET due_date=? WHERE project_id=?";
    $paramsUpdateProject = ['si', $new_date, $project_id];
    $this->execute($sqlUpdateProject, $paramsUpdateProject);

    foreach ($subs as $sub) {


      $phase_id = $sub['phase_id'];
      $sub_old_date = strtotime($sub['due_date']);
      $sub_new_date = date("Y-m-d", $sub_old_date + $dueDiff);


      if ($sub_new_date < $currentDate) {

        $sub_new_date = $currentDate;
      }


      $this->updatePhaseDueDateByPhaseID_ByProjectUpdate($phase_id, $sub_new_date); //
    }

    $subs = $this->getAllTasksDueDateByPhaseID($phase_id);
    "phase_new_due_date" . $subs[0]['due_date'];


    return true;
  }
}
