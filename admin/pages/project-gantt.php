<?php
require('../actions/check-login.php');
require('../class/project.class.php');
require('../class/employee.class.php');
require('../class/Division.class.php');
require('../class/admin.class.php');
require('../class/phase.class.php');





$project = new Project();
$employee = new Employee();
$division = new Division();
$admin = new Admin();
$phase = new Phase();


$allDivs = $division->getAllDivisions();
$allEmployees = $employee->getEmployee_DivisionName();
$perc = $project->getProjectPercentageArray();
$allAdmins = $admin->getAllAdmins();
$allPhases = $phase->getAllPhases();




foreach ($allDivs as $k => $v) {
    $colorCodes[$v['division_id']] = $v['color_code'];
}

if (isset($_GET['project_id'])) {
    // Get the value of the 'id' parameter
    $project_id = $_GET['project_id'];
} else {

    $project_id = $project->getAProjectID();
}

$allTasksDetails = $project->getAllTasksDetails($project_id);

$projectDetails = $project->getProjectDetails($project_id)[0];

$tasks=[];

function convertDateToDMY($dateString)
{
    $dateFor = new DateTime($dateString);
    return $dateFor->format('d-m-Y');
}


foreach ($allTasksDetails as $taskDetails) {


    $taskID = $taskDetails['task_id'];
    $taskName = $taskDetails['task_name'];
    $taskStart = convertDateToDMY($taskDetails['task_start_date']);
    $taskEnd = convertDateToDMY($taskDetails['task_end_date']);
    $color = $taskDetails['color_code'];

    $tasksInfo = array();


    $tasksInfo = array(
        'task_id' => $taskID,
        'task_name' => $taskName,
        'task_start_date' => $taskStart,
        'task_end_date' => $taskEnd,
        'color' => $color
    );

    $tasks= $tasksInfo;
}

$tasksJson = json_encode($tasks);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('../common/head.php'); ?>

    <style>
        .due_date {
            color: grey;
            font-style: italic;
        }

        table th {
            color: white;
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

        .btn-one {
            background-color: #DC3545 !important;
            color: black !important;
        }

        #empCar {
            border: 1px solid black !important;
            border-radius: 9px;
            background-color: #DC3545;
        }

        .d-flex button {
            background-color: #DC3545 !important;
        }

        #gantt_here {
            height: 500px;
            width: 100%;
        }

        .big-input {
            width: 300px;
            height: 30px
        }

        .big-input-height {
            width: 300px;
            height: 60px
        }

        #green-check {
            color: green !important;
        }

        #right_sidebar {
            position: fixed;
            /* or absolute, depending on your layout */
            top: 0;
            right: -20%;
            /* Initially hidden to the right */
            width: 60%;
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

        }



        #overlay {


            position: fixed;
            /* or absolute, depending on your layout */
            top: 0;
            right: -20%;
            /* Initially hidden to the right */
            width: 60%;
            /* Adjust width as needed */
            height: 100%;
            /* Full height */

            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust the last value for transparency */
            z-index: 1000;
            /* Ensure a higher z-index than the sidebar content */
            /* Below the sidebar but above other content */
        }

        h2 {
            font-size: 20px !important;
            font-style: bold !important;
            font-weight: 600 !important;
        }


        .noBorderInput {
            border: none;
            /* Remove border */
            outline: none;
            /* Remove outline */
            padding: 5px;
            /* Add padding for better appearance */
            /* Add any additional styling as needed */
        }

        .small-image {
            width: 30px;
            height: 30px;
            border-radius: 100px;
            display: inline;
        }

        .borderless {
            border: none;
        }

        #subtask_name {
            font-size: 10px;
        }

        #subtasksTable {
            border: 1px solid black;
        }

        #subtasksTable tr:nth-child(even) {
            border-bottom: 1px solid black;
            background-color: aquamarine;

        }

        .sb_item {
            margin: 20px;
        }

        #priority_high i {
            color: red
        }



        #priority_medium i {
            color: yellow
        }

        #priority_low i {
            color: "green"
        }

        .inline {
            display: inline-block !important;
        }

        .above-warning {
            color: #a86632 !important
        }

        /* Change the link color to #111 (black) on hover */
    </style>
</head>

<body>

    <?php require('../elements/modals/employees.php');
    require('../elements/modals/addSubtask.php');
    require('../elements/modals/editSubtaskName.php');


    require('../elements/modals/assignEmpToSubtask.php');
    require('../common/sidebar.php');
    ?>
    <!-- modal-end -->

    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->

        <!-- Spinner End -->


        <!-- Sidebar Start -->

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content zone">
            <!-- Navbar Start -->
            <?php require('../common/navbar.php'); ?>
            <!-- Navbar End -->





            <div class='container-fluid'>
                <div class="row">
                    <div class="col-lg-12">

                        <h1>Project <?php echo $projectDetails["project_name"] ?></h1>

                        <?php require("../elements/projects-nav.php");
                        ?>


                        <!-- <div id="overviewContent">

                </div> -->

                        <div id="ganttContent">
                            <div id="gantt_here">

                            </div>
                        </div>

                        <!-- <div id="listContent">

</div> -->



                        <div id="right_sidebar">


                            <div class="modal r-s" id="docsModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <input type="text" id="employee-searcher" placeholder="Search...">
                                            <i class="fas fa-search search-icon" id="searchIcon"></i>

                                            <select id="assignEmps_divSelector" name="assignEmps_divSelector">
                                                <?php foreach ($allDivs as $div) {
                                                    var_dump($div) ?>
                                                    <option value="<?php echo $div['division_name'] ?>" id="<?php echo $div['division_id'] ?>">
                                                        <?php echo $div['division_name'] ?></option>

                                                <?php    } ?>
                                            </select>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form method="post" action="../actions/subtasks/assign_emp_to_subtask.php" id='assignEmpForm'>

                                                <div id="nonAssignedEmpsContainer">

                                                </div>


                                            </form>
                                        </div>
                                        <button type="submit" id="assignEmpBtn" class="btn btn-danger">ASSIGN</button>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div>
                                <input type="checkbox" id="taskCheckbox">
                            </div>


                            <div class="sb_item">
                                <h2 id="taskPhaseHeader">Phase:
                                    <div class="inline" id="sb_taskPhase">

                                        <select id="taskPhaseSelect">
                                            <?php foreach ($allPhases as $phase) { ?>
                                                <option value="<?php echo $phase['phase_name'] ?>" id="<?php echo $phase['phase_id'] ?>">
                                                    <?php echo $phase['phase_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </h2>
                                <span><input type="date" id="phaseDueDate" readonly></span>

                            </div>




                            <div class="sb_item">
                                <h2 id="taskNameHeader">Task:</h2>

                                <div class="inline" id="sb_taskName">

                                </div>
                                &nbsp; <label for="task_due_date" class="due_date" pattern="\d{1,2}/\d{1,2}/\d{4}"> Due Date: </label>
                                <input type="date" id="task_due_date" class="due_date" value>

                            </div>


                            <div class="sb_item">
                                <h2 id="taskPriorityHeader">Priority:
                                    <div class="inline" id="sb_taskPriority">

                                        <form action='../actions/tasks/update_task.php'>
                                            <select id="taskPrioritySelect">

                                                <option id="priorit_low" value="Low"><i class="fa-solid fa-circle"></i>Low</option>
                                                <option id="priority_medium" value="Medium"><i class="fa-solid fa-circle"></i>Medium</option>
                                                <option id="priority_high" value="High"><i class="fa-solid fa-circle"></i>High</option>

                                            </select>
                                        </form>
                                    </div>
                                </h2>

                            </div>




                            <div class="sb_item">
                                <h2 class="inline" id="taskStatus">Status:
                                    <div class="inline" id="sb_taskStatus">

                                        <form action='../actions/tasks/update_task.php'>
                                            <select id="taskStatusSelect">

                                                <option value="In Progress"><i class="fa-solid fa-circle"></i>In Progress</option>
                                                <option value="Paused"><i class="fa-solid fa-circle"></i>Paused</option>
                                                <option value="Completed"><i class="fa-solid fa-circle"></i>Completed</option>


                                            </select>
                                        </form>
                                    </div>
                                </h2>

                            </div>



                            <div class="sb_item">
                                <h2 id=''>Subtasks</h2>

                                <i class="fa fa-plus" id="addSubtaskIcon">ADD SUB</i>
                                <select id="dueDateSort">
                                    <option value="earliest" id="dueDateEarliest">Earliest</option>
                                    <option value="latest" id="dueDateLatest">Latest</option>

                                </select>
                                <form method="post" action="../actions/subtasks/add_subtask.php" id='addSubtaskForm'>

                                    <input type="text" id="addSubtaskInput" name="addSubtaskInput" class="big-input">


                                </form>

                                <table class="" id="subtasksTable">
                                </table>


                            </div>

                            <div class="sb_item">
                                <h2 id="sb_taskDesc">Task Description:</h2>
                                <span><input type="text" id="taskDescInput" name="taskDescInput" class="big-input-height"></span>

                            </div>




                            <!-- <div align='right' style='margin:10px 0px 10px 10px'>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerEmployeeModal">
    ADD EMPLOYEE
  </button>
            </div> -->


                            <!-- Bootstrap dropdown converted to select element -->

                            <div id="overlay">
                                <button id="unMarkTaskButton" class="btn btn-secondary btn-lg">Unmark Task As Completed</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Content End -->


            <!-- Back to Top -->
            <form action="../actions/employees/register_employee.php" enctype="multipart/form-data">
                <input type="file" name="pp">
                <button type="submit"> </button>
            </form>

            <!-- JavaScript Libraries -->

            <?php require('../common/script.php') ?>
            <!-- Template Javascript -->



            <script>
                var tasks = <?php echo $tasksJson ?>;
                console.log(tasks);

                //to get the old date in case inserting a new one was not allowed
                let project_id = <?php echo $project_id; ?>;

                var currentTask_id;

                var empAssignArray = [];







                $(document).ready(function() {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                    $("#overlay").hide();


                    var dateInputs = $('input[type="date"]');

                    // Set the min attribute for each date input
                    dateInputs.each(function() {
                        this.min = new Date().toISOString().split('T')[0];
                    });

                    $("#dueDateSort").on("change", function() {

                        getSubtaskDetails(currentTask_id)
                    })

                    // $(document).on("click", function(e) {
                    //     if ((!$(e.target).closest("#right_sidebar").length && !$(e.target).closest(".r-s").length) && $("#right_sidebar").is(":visible")) {
                    //         $("#right_sidebar").hide();
                    //     }
                    // });


                    // Hide right sidebar when clicking outside
                    $(document).on("click", function(e) {
                        if (
                            $(e.target).closest(".zone").length > 0 &&
                            $("#right_sidebar").is(":visible") &&
                            (!$(e.target).closest("#right_sidebar").length)
                        ) {
                            // Your code to hide the #right_sidebar
                            $("#right_sidebar").hide();
                        }

                    });


                    $("#addSubtaskInput").hide()

                    $("#subtask-edit-submit").on('click', function(e) {

                        e.preventDefault()
                        let form = $("#editSubtaskNameForm").serialize();
                        $.ajax({
                            url: '../actions/subtasks/edit_subtask_name.php',
                            data: form,
                            type: 'POST',
                            success: function(result) {

                                getSubtaskDetails(currentTask_id)
                                getTasksDetailsAndInitiateGantt(project_id)
                                $("#editSubtaskNameModal").modal('hide');


                            }
                        })
                    })


                    $("#right_sidebar").hide();
                    updateTaskName();
                    taskNameAjax();
                    InitiateGantt(tasks);



                    $("#taskNameForm").hide();

                    openTaskDetails()

                    $('#sb_subtasks').on('click', '.assignEmp', function() {
                        let subtask_id = $(this).attr('id');
                        $("#assignEmpModal").modal('show');


                    })

                    $("document").on('change', '.sb-start-date', function() {
                        alert('sa')
                        let subtask_id = $(this).attr('data');
                        let start_date = $(this).val();

                        editSubtaskStartDate(subtask_id, start_date);
                    })

                    $("document").on('change', '.sb-start-date', function() {
                        let subtask_id = $(this).attr('data');
                        let start_date = $(this).val();

                        editSubtaskStartDate(subtask_id, start_date);
                    })





                    $("#addSubtaskForm").on('submit', function(e) {
                        addSubtask(task_id)

                    })


                })



                // Event delegation for dynamically added date inputs


                function editSubtaskStartDate(subtask_id, start_date) {

                    $.ajax({
                        url: '../actions/subtasks/edit-subtask-dates.php',
                        data: {
                            subtask_id,
                            start_date
                        },
                        type: 'POST',
                        success: function(result) {


                        }
                    })
                }

                function editSubtaskEndDate(subtask_id, end_date) {

                    $.ajax({
                        url: '../actions/subtasks/edit-subtask-dates.php',
                        data: {
                            subtask_id,
                            end_date
                        },
                        type: 'POST',
                        success: function(result) {


                        }
                    })
                }





                function ganttAjax() {
                    $.ajax({
                        url: $(this).attr('action'),
                        data: form,
                        type: 'POST',
                        success: function(result) {
                            if (result.status == 'ok') {

                                $.ajax({
                                    url: "",
                                    data: form,
                                    type: 'POST',
                                    success: function(result) {
                                        if (result.status == 'ok') {


                                        }
                                    }
                                })
                            }
                        }
                    })
                }




                function openTaskDetails() {
                    var sidebar = $("#right_sidebar");
                    var overlay = $("#overlay");

                    gantt.attachEvent("onTaskClick", function(taskId, e) {
                        let foundTask = tasks.find(function(task) {

                            return task.task_id === 19;
                        });
                        $("#navbar").hide();
                        $("#right_sidebar").show();


                        e.stopPropagation()

                        currentTask_id = taskId
                        getSubtaskDetails(currentTask_id)
                        getTaskDetailsForight_sidebar(currentTask_id)

                        sidebar.css("right", "0");

                        overlay.css("right", "0"); // Open sidebar by setting right to 0

                        // let html=`<h1>${foundTask["task_name"]}</h1>`
                        //         //   `<div class="empCard">${foundTask`

                        // $("#sidebar").html(html);   





                    });
                }





                function InitiateGantt(tasks) {
                    console.log(tasks);

                    gantt.config.layout = {
                        css: "gantt_container",
                        rows: [{
                            cols: [{
                                    view: "grid",
                                    scrollY: "scrollVer"
                                },
                                {
                                    resizer: true,
                                    width: 10
                                },
                                {
                                    view: "timeline",
                                    scrollY: "scrollVer"
                                },
                                {
                                    view: "scrollbar",
                                    id: "scrollVer"
                                }
                            ]
                        }]
                    };

                    gantt.config.columns = [

                        {
                            name: "add",
                            label: " ",
                            width: 44
                        },
                        {
                            buttons: true,
                            width: 100
                        } // Assuming you want a button column
                    ];

                    console.log(tasks);


                    // Initialize DHTMLX Gantt


                    gantt.init("gantt_here");



                    // Load sample data (replace with your own data)


                    var newTasks = [];
                    tasks.forEach(task => {
                        console.log(task);
                        if (typeof task[2] === 'string') {
                            console.log(task[2]);
                        }


                        var newTask = {
                            id: parseInt(task['task_id']),
                            text: task['task_name'],
                            start_date: task['task_start_date'],
                            duration: 3,
                            color: task['color']
                        };

                        console.log('task_', task['task_start_date'])


                        newTasks.push(newTask); // Add the newTask object to the newTasks array
                    })
                    console.log(newTasks);



                    gantt.parse({
                        data: newTasks
                    });

                    var taskEle = gantt.getTaskNode(19)
                    console.log(taskEle);

                    gantt.attachEvent("onMouseWheel", function(delta, event) {
                        if (delta < 0 && gantt.config.scale_unit == "year") {
                            gantt.config.scale_unit = "month";
                            gantt.config.date_scale = "%F, %Y";
                            gantt.render();
                            return false;
                        } else if (delta > 0 && gantt.config.scale_unit == "month") {
                            gantt.config.scale_unit = "year";
                            gantt.config.date_scale = "%Y";
                            gantt.render();
                            return false;
                        }
                    });

                    gantt.attachEvent("onAfterTaskAdd", function(id, task) {

                        console.log(task);
                        start_date = task.start_date;
                        end_date = task.end_date;
                        task_name = task.text;

                        console.log(task);
                        console.log("Task added with start date:", start_date, "and end date:", end_date);
                        addTask(project_id, task_name, task.start_date, task.end_date);
                    });


                    gantt.attachEvent("onAfterTaskUpdate", function(id, task) {
                        updateTaskTimes(task.id, task.start_date, task.end_date);
                        console.log(task.id, task.start_date, task.end_date)
                    });


                }

                function getTasksDetailsAndInitiateGantt(project_id) {
                    $("#gantt_here").html('')
                    $.ajax({
                        url: '../actions/projects/get_tasks_details_for_gantt.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            project_id
                        },
                        success: function(response) {
                            console.log(response.tasks);
                            InitiateGantt(response.tasks);
                        }
                    })
                }

                function getTaskDetailsForight_sidebar(task_id) {

                    let taskNameDiv = $("#sb_taskName")
                    let taskPrioritySelect = $("#taskPrioritySelect")
                    let taskStatusSelect = $("#taskStatusSelect")
                    let taskDescInput = $("#taskDescInput")
                    let taskPhaseSelect = $("#taskPhaseSelect")
                    let taskCheckBox = $("#taskCheckbox")
                    let phaseDueDate = $("#phaseDueDate")
                    let unMarkTaskButton = $("#unMarkTaskButton")
                    let overlay = $("#overlay")
                    let rs = $("#right_sidebar")


                    $.ajax({
                        url: '../actions/tasks/get_task_details_for_sidebar.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id
                        },
                        success: function(response) {
                            console.log(response)
                            let taskName = response[0].task_name
                            let taskPriority = response[0].task_priority
                            let taskStatus = response[0].status
                            let taskDesc = response[0].task_description
                            let task_due_date = response[0].due_date
                            let taskPhase = response[0].phase_name
                            let phase_due_date = response[0].phase_due_date


                            $("#task_due_date").val(task_due_date);
                            $('#task_due_date').data('old_due', task_due_date);


                            let taskNameInputHTML =
                                `<p class="taskNameParag" id="taskNameParag">
                                ${taskName}
                            <i class="fa fa-edit" id="editTaskName">Edit</i>
                                </p>
                                <form id="taskNameForm" action='../actions/tasks/update_task.php'>
                                <input hidden value="${taskName}" id="taskNameInput" type="text">
                                </form>`
                            taskNameDiv.html(taskNameInputHTML)


                            taskPhaseSelect.find('option').each(function() {
                                if ($(this).val() == taskPhase) {
                                    $(this).attr('selected', 'selected');
                                }
                            });

                            phaseDueDate.val(phase_due_date);


                            taskPrioritySelect.find('option').each(function() {
                                if ($(this).val() == taskPriority) {
                                    $(this).attr('selected', 'selected');
                                }
                            });


                            taskStatusSelect.find('option').each(function() {
                                if ($(this).val() == taskStatus) {
                                    $(this).attr('selected', 'selected');
                                }
                            });

                            taskDescInput.val(taskDesc)


                            $("#task_due_date").on('change', function() {
                                let task_due_date = $("#task_due_date").val();
                                let taskDateEl = $(this)
                                let old_due = $(this).data('old_due')
                                $.ajax({
                                    url: '../actions/tasks/edit_task_due_date.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    data: {
                                        task_id,
                                        task_due_date

                                    },
                                    success: function(response) {
                                        if (response.status == 'success') {
                                            toastr.success(response.message_tasks);
                                            toastr.success(response.message_subtasks);
                                            getTaskDetailsForight_sidebar(task_id)
                                            getSubtaskDetails(task_id);

                                            getTasksDetailsAndInitiateGantt(project_id)
                                        } else {
                                            toastr.warning(response.message);
                                            taskDateEl.val(old_due);

                                        }
                                    }
                                })

                            })


                            let taskNameInput = $('#taskNameInput')
                            updateTaskName();
                            taskNameAjax();
                            taskPriorityAjax(task_id);
                            taskStatusAjax(task_id);
                            taskDescAjax(task_id);
                            taskPhaseAjax(task_id);

                            if (taskStatusSelect.val() == 'Completed') {
                                // Set background color to white

                                $(taskCheckBox).prop('checked', true);

                                // Show the overlay
                                overlay.show();
                            } else {
                                $(taskCheckBox).prop('checked', false);

                                // Hide the overlay
                                overlay.hide();

                            }

                            taskCheckBox.on('change', function() {

                                // if (taskCheckBox.prop('checked')) {
                                //     // Set the value of taskStatusSelect to 'completed'
                                //     taskStatusSelect.val('Completed');

                                //     // Trigger the change event on taskStatusSelect
                                //     taskStatusSelect.trigger('change');
                                // }
                            });



                            unMarkTaskButton.on('click', function() {


                                taskStatusSelect.val('In Progress');
                                taskStatusSelect.trigger('change');

                            })
                        }
                    })
                }


                function taskPriorityAjax(task_id) {
                    $('#taskPrioritySelect').on('change', function() {
                        let task_priority = $('#taskPrioritySelect').val();
                        $.ajax({
                            url: '../actions/tasks/edit_task_details_by_sidebar.php',
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                task_id,
                                task_priority
                            },
                            success: function(response) {
                                getTaskDetailsForight_sidebar(task_id)

                                getTasksDetailsAndInitiateGantt(project_id)
                            }
                        })
                    })
                }

                function taskPhaseAjax(task_id) {
                    $('#taskPhaseSelect').on('change', function() {
                        let phase_id = $('#taskPhaseSelect option:selected').attr('id');

                        $.ajax({
                            url: '../actions/tasks/edit_task_details_by_sidebar.php',
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                task_id,
                                phase_id
                            },
                            success: function(response) {
                                getTaskDetailsForight_sidebar(task_id)

                                getTasksDetailsAndInitiateGantt(project_id)
                            }
                        })
                    })
                }

                function taskDescAjax(task_id) {

                    $('#taskDescInput').on('click', function() {

                        $("#taskDescInput").addClass('isActive');

                        $(document).on('click', function(e2) {

                            if (!$(e2.target).hasClass("isActive") && $("#taskDescInput").hasClass("isActive")) {
                                $("#taskDescInput").removeClass("isActive")
                                let task_description = $("#taskDescInput").val();
                                $.ajax({
                                    url: '../actions/tasks/edit_task_details_by_sidebar.php',
                                    data: {
                                        task_id,
                                        task_description
                                    },
                                    type: 'POST',
                                    success: function(result) {
                                        getTaskDetailsForight_sidebar(task_id)

                                        getTasksDetailsAndInitiateGantt(project_id)

                                    }
                                })
                            }
                        })
                    })
                }


                function taskStatusAjax(task_id) {
                    $('#taskStatusSelect').on('change', function() {
                        let task_status = $('#taskStatusSelect').val();
                        $.ajax({
                            url: '../actions/tasks/edit_task_details_by_sidebar.php',
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                task_id,
                                task_status
                            },
                            success: function(response) {
                                getTaskDetailsForight_sidebar(task_id)
                                getTasksDetailsAndInitiateGantt(project_id)
                            }
                        })
                    })
                }

                function addSubtask(task_id) {
                    $.ajax({
                        url: '../actions/tasks/get_subtask_details.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id: task_id
                        },
                        success: function(response) {

                        }
                    })
                }

                function getSubtaskDetails(task_id) {
                    let sort_by = $("#dueDateSort").val();
                    let todate = new Date();
                    $("#subtasksTable").html('');

                    $.ajax({
                        url: '../actions/tasks/get_subtask_details.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id: task_id,
                            sort_by
                        },
                        success: function(response) {
                            let st = $('#sb_subtasks')
                            $('#subtasksTable').html('')
                            $('#docsTable').html('')
                            console.log(response)

                            response.forEach(element => {
                                let assignees = element.assignees;
                                let nonAssigned = element.nonAssigned
                                let due_date = element.due_date
                                let docs = element.docdetails;
                                let checkSpan;
                                let subtask_name = element['subtask_name'];
                                let subtask_status = element['subtask_status'];
                                let subtask_id = element['subtask_id'];



                                let assigneeImagesHTML = '';
                                element['assignees'].forEach(assignee => {
                                    assigneeImagesHTML += `<img class="small-image" src="../images/pp/${assignee['pp']}">`;
                                });

                                let docDetailsHTML = '';
                                element['docdetails'].forEach(docDetail => {
                                    docDetailsHTML += `<img class="small-image" src="${docDetail['image_path']}">`;
                                });

                                let subtasksHTML = `
  
        <tr id='${subtask_id}'>
        <th class='subtask_name'>${subtask_name}
          <i class="fa fa-edit subtask_name_edit_icon" data-subtask_id="${subtask_id}" data-subtask_name="${subtask_name}">edit</i>
          <i class="fa fa-ban subtask_delete_icon" data-subtask_id="${subtask_id}">Delete</i></th>                    
           <th><label>Due Date:<input data-subtask_id=${subtask_id} data-old_due=${due_date} type="date" name="st_start_date" value="${due_date}" class='st_due_date date'></label></th>    
                                `


                                due_date = new Date(due_date)
                                var differenceInMilliseconds = todate - due_date
                                var differenceInHours = differenceInMilliseconds / (1000 * 60 * 60);




                                if (differenceInHours >= 24 && differenceInHours < 48) {
                                    subtasksHTML += `<th class='text-warning'>Due Tomorrow</th>`
                                } else if (differenceInHours < 24 && differenceInHours >= 0) {
                                    subtasksHTML += `<th class="above-warning">Due Today</th>`
                                } else if (differenceInHours < 0) {
                                    subtasksHTML += `<th class="text-danger">Passed Due Date</th>`
                                }

                                if (subtask_status === "Completed") {
                                    subtasksHTML += `<th><i class='fa-solid fa-check st_checked' data-subtask_id='${subtask_id}'>Tick</i></th></tr>`;
                                } else {
                                    // Use a class instead of an ID for styling
                                    subtasksHTML += `<th><i class='fa-solid fa-check check-not-done st_unchecked' data-subtask_id='${subtask_id}'>UnTick</i></th></tr>`;
                                }



                                subtasksHTML += `  <tr>
       
        <th><i class="fa-solid fa-person-circle-plus assignEmpIcon" data-subtask_id="${subtask_id}">assign</i></th>
            
        <th class="showAssignees">${assigneeImagesHTML}</th>
      
            <th> <i class="showDocsIcon fa-solid fa-file" data-subtask_id=${subtask_id}>Docs</i></th>
            <th></th></tr>`






                                $('.docImg').on('click', function() {
                                    window.open($(this).attr('src'), '_blank');
                                })
                                // Append the constructed HTML to the 'sb_subtasks' element
                                $("#subtasksTable").append(subtasksHTML);

                            })

                            $(".st_due_date").on('change', function() {
                                let subtask_id = $(this).data('subtask_id')
                                let st_new_date = $(this).val();
                                let stElement = $(this)
                                let old_due = stElement.data('old_due')

                                $.ajax({
                                    url: '../actions/subtasks/edit_subtask_times.php',
                                    data: {
                                        st_new_date,
                                        currentTask_id,
                                        subtask_id

                                    },
                                    type: 'POST',
                                    success: function(response) {
                                        if (response.status == 'error') {
                                            stElement.val(old_due)

                                            toastr.warning(response.message_error);
                                        } else {
                                            $("#addSubtaskInput").hide()
                                            getSubtaskDetails(task_id)
                                            toastr.success('subtasks due times changed');


                                        }

                                    }
                                })
                            })
                            $('.date').attr('min', new Date().toISOString().split('T')[0]);


                            $(".subtask_name_edit_icon").on('click', function() {


                                let subtask_name = $(this).data('subtask_name');
                                let subtask_id = $(this).data('subtask_id');

                                let editSubtaskInput = $("#editSubtaskInput")
                                let editSubtaskInput_ID = $("#editSubtaskInput_ID")
                                editSubtaskInput.val(subtask_name);
                                editSubtaskInput_ID.val(subtask_id);
                                $("#editSubtaskNameModal").modal("show")
                            })


                            $(".subtask_delete_icon").on('click', function() {



                                let subtask_id = $(this).data('subtask_id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'You won\'t be able to revert this!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!',
                                    customClass: {
                                        container: 'r-s' // Add your custom class here
                                    }
                                }).then((result) => {
                                    // If the user clicks "Yes"
                                    if (result.isConfirmed) {
                                        // Perform the deletion
                                        $.ajax({
                                            url: '../actions/subtasks/delete_subtask.php',
                                            data: {
                                                subtask_id
                                            },
                                            type: 'POST',
                                            success: function(result) {
                                                if (result.status == 'success') {

                                                    getSubtaskDetails(task_id)

                                                } else {
                                                    toastr.warning(result.message);
                                                }
                                            }
                                        })
                                    }
                                });

                            })



                            $('#addSubtaskIcon').click(function(e) {
                                e.stopPropagation()
                                $("#addSubtaskInput").show()
                                $("#addSubtaskInput").addClass('isActive');

                                $(document).on('click', function(e2) {


                                    if (!$(e2.target).hasClass("isActive") && $("#addSubtaskInput").hasClass("isActive")) {

                                        $("#addSubtaskInput").removeClass("isActive")
                                        let new_subtask_name = $("#addSubtaskInput").val();
                                        $.ajax({
                                            url: '../actions/subtasks/add_subtasks.php',
                                            data: {
                                                currentTask_id,
                                                new_subtask_name
                                            },
                                            type: 'POST',
                                            success: function(result) {
                                                if (result.status == 'success') {
                                                    $("#addSubtaskInput").hide()
                                                    getSubtaskDetails(task_id)

                                                } else {
                                                    toastr.warning(result.message);
                                                }
                                            }
                                        })

                                    }
                                })
                            })

                            // if ($("#addSubtaskInput").hasClass("isActive") && !$(e.target).hasClass("isActive")) {


                            $('.assignEmpIcon').click(function() {
                                let subtask_id = $(this).data('subtask_id');
                                $('#assignEmpModal').modal('show');
                                getNonAssEmps(subtask_id)
                                assignEmpsAjax(subtask_id);
                            });



                            $('.showAssigneesIcon').click(function() {
                                $('#assigneesModal').modal('show');
                            });

                            $('.st_checked').on('click', function() {
                                let subtask_id = $(this).data('subtask_id');
                                let status = 'In Progress'

                                changeSubtaskStatus(subtask_id, status)

                            })

                            $('.st_unchecked').on('click', function() {
                                let subtask_id = $(this).data('subtask_id');
                                let status = 'Completed'

                                changeSubtaskStatus(subtask_id, status)

                            })


                            openDocsModal(task_id)
                        }
                    })
                }


                function openDocsModal(task_id) {
                    $(".showDocsIcon").on('click', function() {
                        $("#docsModal").modal('show');

                        let subtask_id = $(this).data('subtask_id')

                        buildDocsModal(subtask_id, task_id)
                    })
                }


                function buildDocsModal(subtask_id, task_id) {
                    $.ajax({
                        url: '../actions/tasks/get_subtask_details.php',
                        data: {
                            subtask_id,
                            'key': 'forDocs'
                        },
                        type: 'POST',
                        success: function(result) {
                            if (result.status == 'success') {

                                let assignees = result.ad
                                let docs = result.docs

                                let docsHTML = `<table>
                                    
                                    `
                                assignees.forEach(assignee => {

                                    docsHTML += `<tr><td><i class='fa fa-ban unassignIcon' data-assignee_id=${assignee.assignee_id}>delete</i>
                                   <img class="small-image" src="../images/pp/${assignee['pp']}"></td>
    <td>${assignee["assignee_fn"]} ${assignee["assignee_ln"]}</td><td>`



                                    docs.forEach(doc => {
                                            if (doc['posted_by'] == assignee['assignee_id']) {

                                                docsHTML += `<a href="../images/docs/${doc['image_path']}" target="_blank"><img src="../images/docs/${doc['image_path']}" class="small-image doc"></a>
                                                <i class="fa fa-ban delete-doc" data-image_id=${doc['image_id']}>delete</i><br>`

                                            }
                                        }


                                    )

                                    docsHTML += `</td></tr>`

                                    console.log(docsHTML)

                                });

                                $("#docsTable").html(docsHTML);

                                unAssignEmp(subtask_id, task_id)
                                deleteDoc(task_id);
                            }
                        }
                    })
                }

                function deleteDoc(task_id) {
                    $(".delete-doc").click(function() {
                        let image_id = $(this).data("image_id");

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            $.ajax({
                                url: '../actions/subtasks/delete_doc.php',
                                data: {
                                    image_id

                                },
                                type: 'POST',
                                success: function(response) {
                                    if (response.status == 'success') {
                                        buildDocsModal(subtask_id)
                                        getSubtaskDetails(task_id)

                                    }
                                }
                            })

                        })
                    })
                }

                function unAssignEmp(subtask_id, task_id) {
                    $(".unassignIcon").click(function() {

                        let ass_id = $(this).data("assignee_id");

                        $.ajax({
                            url: '../actions/subtasks/unassign_emp.php',
                            data: {
                                ass_id,
                                subtask_id

                            },
                            type: 'POST',
                            success: function(response) {
                                if (response.status == 'success') {
                                    buildDocsModal(subtask_id)
                                    getSubtaskDetails(task_id)

                                }
                            }
                        })
                    })
                }


                function changeSubtaskStatus(subtask_id, subtask_status) {
                    $.ajax({
                        url: '../actions/subtasks/change-status.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            subtask_id,
                            subtask_status
                        },
                        success: function(result) {
                            getSubtaskDetails(currentTask_id)
                        },

                        error: function(xhr, status, error) {
                            console.error("AJAX request failed:", xhr, status, error);
                            // You can add additional error handling code here, such as displaying an error message to the user.
                        }

                    });
                }

          

                function assignEmpsAjax(subtask_id) {

                    $("#assignEmpBtn").on('click', function() {



                        $.ajax({
                            url: '../actions/subtasks/assign_emp_to_subtask.php',
                            data: {
                                subtask_id,
                                empAssignArray
                            },
                            dataType: "json",
                            type: 'POST',
                            success: function(result) {
                                empAssignArray = [];
                                console.log(empAssignArray);
                                $('#assignEmpModal').modal('hide');

                                getSubtaskDetails(currentTask_id)
                            },
                            error: function(request, status, error) {
                                toastr.warning('error')

                            }
                        })
                    })
                }

                function addTask(project_id, task_name, e_start_date, e_end_date) {


                    $.ajax({
                        url: '../actions/tasks/add_task.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            project_id,
                            task_name,
                            e_start_date,
                            e_end_date
                        },

                        success: function(result) {

                            alert('yes')



                        }
                    })
                }


                function getNonAssEmps(st_id, filter = '') {


                    let division_id = $("#assignEmps_divSelector option:selected").attr("id");




                    $.ajax({
                        url: '../actions/tasks/get_unassigned_emps.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            division_id,
                            st_id,
                            filter
                        },
                        success: function(result) {


                            populateNonAssEmpsModal(result);

                            Filter(st_id)
                            changeAssignmentDivSearch(st_id)
                        }
                    })
                }

                function changeAssignmentDivSearch(st_id) {
                    $("#assignEmps_divSelector").on('change', function() {
                        let division_id = $(this).find(':selected').attr("id");
                        $("#employee_searcher").val('')
                        getNonAssEmps(division_id); //

                    })
                }


                function Filter(st_id) {
                    $("#employee_searcher").on("input", function() {

                        let filter = $(this).val()
                        getNonAssEmps(st_id, filter)
                    })
                }

                function colorEmpsCards() {
                    $(".employee-filter").on("click", function() {
                        let employeeID = $(this).attr('id'); // Use data method to get the data-employee_id attribute

                        // Check if employeeID is in the array
                        let index = empAssignArray.indexOf(employeeID);

                        if (index !== -1) {
                            // If employeeID is in the array, remove it
                            empAssignArray.splice(index, 1);
                            $(this).removeClass('employee-filter-alter');
                            $(this).addClass('employee-filter');
                        } else {
                            // If employeeID is not in the array, add it
                            empAssignArray.push(employeeID);
                            $(this).removeClass('employee-filter');
                            $(this).addClass('employee-filter-alter');
                        }
                        console.log(empAssignArray)
                    });
                }



                function populateNonAssEmpsModal(empsArray) {

                    nonAssignedEmpsContainer = $("#nonAssignedEmpsContainer")
                    nonAssignedEmpsContainer.empty()
                    empsArray.forEach(employee => {



                        var nonAssignedEmployee = ` <div class="employee-filter white" id="${employee.employee_id}">
    <span>
        <img class="small-image" src="../images/pp/${employee.pp}">
    </span>
    <span>${employee.employee_fn}</span>
</div>
`


                        nonAssignedEmpsContainer.html(nonAssignedEmployee);
                    })
                    colorEmpsCards()
                }



                function updateTaskTimes(task_id, task_name = '', task_desc = '', task_status = '', e_start_date, e_end_date) {


                    $.ajax({
                        url: '../actions/tasks/update_task.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id,
                            e_start_date,
                            e_end_date
                        },

                        success: function(result) {

                            alert('yes')
                            getTasksDetailsAndInitiateGantt(project_id)



                        }
                    })
                }

                function deleteTaskTimes(task_id, task_name) {



                    asdasdan.deleteTaskTimes(task_status)
                }

                function updateTaskName() {
                    $("#editTaskName").on("click", function(e) {
                        e.stopPropagation(); // Stop event propagation
                        $("#taskNameInput").removeAttr("hidden")
                        $('#taskNameInput').addClass('isActive');
                        $("#editTaskName").hide();
                        $("#taskNameParag").hide();
                    });
                }


                function taskNameAjax() {
                    $(document).on('click', function(e) {

                        console.log(currentTask_id);


                        if ($("#taskNameInput").hasClass("isActive") && !$(e.target).hasClass("isActive")) {

                            $("#taskNameInput").removeClass("isActive")
                            let form = $("#taskNameForm").serialize();

                            let task_name = $("#taskNameInput").val();
                            let task_id = currentTask_id

                            $.ajax({
                                url: '../actions/tasks/edit_task_details_by_sidebar.php',
                                data: {
                                    task_name,
                                    task_id: currentTask_id
                                },

                                type: 'POST',
                                success: function(response) {
                                    if (response.status == 'ok') {

                                        getTaskDetailsForight_sidebar(currentTask_id)
                                        getTasksDetailsAndInitiateGantt(project_id)
                                    }
                                }
                            });
                        }
                    });

                }
            </script>
            <script src="../js/createDocsTableModal.js"></script>

</body>

</html>