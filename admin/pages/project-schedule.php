<?php
require('../actions/check-login.php');
require('../class/project.class.php');
require('../class/employee.class.php');
require('../class/Division.class.php');
require('../class/admin.class.php');





$project = new Project();
$employee = new Employee();
$division = new Division();
$admin = new Admin();


$allDivs = $division->getAllDivisions();
$allEmployees = $employee->getEmployee_DivisionName();
$perc = $project->getProjectPercentageArray();
$allAdmins = $admin->getAllAdmins();
$colorCodes = array();

foreach ($allDivs as $k => $v) {
    $colorCodes[$v['division_id']] = $v['color_code'];
}

$colorCodes = json_encode($colorCodes);


if (isset($_GET['project_id'])) {
    // Get the value of the 'id' parameter
    $project_id = $_GET['project_id'];
    $project_id_json = json_encode($project_id);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('../common/head.php'); ?>


    <style>
        table th {
            color: white;
        }

        .emp_card {
            border-radius: 100px !important;
            background-color: #DC3545 !important;
            color: black !important;
            padding: 8px !important;
            margin-top: 10px !important;
            width: 300px !important;

        }

        h1 {
            font-size: 40px !important;
            font-style: italic;
        }

        h2 {
            font-size: 30px !important;
            font-style: italic;
        }

        .active {

            background-color: #DC3545 !important;
        }

        .clicked {
            border: 2px solid black !important;
            box-shadow: 0 0 10px rgba(255, 255, 0, 0.5) !important;
        }


        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* #edit_project_name{
            display:none
        } */

        #right_sidebar {
            position: fixed;
            /* or absolute, depending on your layout */
            top: 0;
            right: -20%;
            /* Initially hidden to the right */
            width: 50%;
            /* Adjust width as needed */
            height: 100%;
            /* Full height */
            z-index: 1000;
            /* Ensure this is higher than the navbar's z-index */
            background-color: white;
            /* Or any color */
            /* Add transition for smooth sliding effect */
            transition: right 0.5s;
            overflow-y: auto;
            padding-top: 100px;

        }

        .circle {
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            border: none !important;
            outline: none !important;
            cursor: pointer !important;
            background-color: transparent !important;
        }


        .rs-item {
            margin-left: 60px !important;
        }

        .btn {
            border: 1px solid black;
        }

        #off-track:hover {
            background-color: red !important;
        }

        #on-track:hover {
            background-color: green !important;
        }


        #at-risk:hover {
            background-color: yellow !important;
        }

        #addManagerBtn {
            width: 200px !important;
            padding: 5px !important;
        }

        .removeManagerIcon {
            display: inline;
        }

        .percent {
            color: black;
            display: inline-block;
            position: relative;
            text-align: center;
        }

        .percent-inside {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 100%;
        }

        .progress-bar-container {
            width: 40%;
            background-color: #f0f0f0;
        }

        .progress-bar {
            height: 20px;
            background-color: #4caf50;
            /* Green */
            width: 0%;
            transition: width 0.3s ease;
        }

        .srollabale {
            overflow-y: auto;

        }

        /* Change the link color to #111 (black) on hover */
    </style>

    <link rel="stylesheet" type="text/css" href="path/to/scheduler.css">
    <script src="path/to/scheduler.js"></script>

</head>

<body>
    <!-- modal-end -->
    <?php require('../common/sidebar.php'); ?>
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'> 
        <div class="dhx_cal_navline"> 
            <div class="dhx_cal_prev_button">&nbsp;</div> 
            <div class="dhx_cal_next_button">&nbsp;</div> 
            <div class="dhx_cal_today_button"></div> 
            <div class="dhx_cal_date"></div> 
            <div class="dhx_cal_tab" name="day_tab"></div> 
            <div class="dhx_cal_tab" name="week_tab"></div> 
            <div class="dhx_cal_tab" name="month_tab"></div> 
    </div> 
    <div class="dhx_cal_header"></div> 
    <div class="dhx_cal_data"></div> 
    </div> 

 

</body>

</html>

<?php require('../common/script.php') ?>

<script>
    // scheduler.init('scheduler_here', new Date(2019, 0, 20), "week");
    // scheduler.load("data/api.php");
</script>