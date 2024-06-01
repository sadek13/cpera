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
            font-size: 20px !important;
        }

        .hidden-row {
            display: none;
        }

        .green {
            color: green
        }

        #add_task_button {
            background-color: #DC3545;
            margin: 10px;

        }

        .subtask_row {
            background-color: aquamarine;
        }
    </style>
</head>

<body>
    <!-- modal-end -->
    <?php require('../common/sidebar.php');
    ?>

    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->

        <!-- Spinner End -->


        <!-- Sidebar Start -->

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content zone">
            <!-- Navbar Start -->
            <?php require('../common/navbar.php');
            require('../elements/modals/editPhase.php');
            require('../elements/modals/addPhase.php');
            require('../elements/modals/addProjectManager.php');
            require('../elements/modals/add_task_and_sub.php'); ?>

            <!-- Navbar End -->





            <div class='container-fluid'>
                <div class="row">
                    <div class="col-lg-12">
                        <h1>My Tasks</h1>

                        <!-- <button class='btn btn-lg' id='add_task_button'>ADD TASK</button> -->
                        <div id='list-view'>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>

<?php require('../common/script.php') ?>

<script>
    $(document).ready(function() {

        getProjectDetails('desc')


    })

    function getProjectDetails(due_date = 'desc', priority = '', status = '') {
        let listView = $('#list-view')
        console.log(status)

        $.ajax({
            url: '../actions/projects/get_all_projects_details.php',
            data: {
                due_date,
                priority,
                status
            },
            type: 'POST',
            success: function(response) {
                if (response.status == 'success') {

                    buildListViewTable(response.allDetails, response.due_date, response.priority, response.task_status)

                } else {



                }

            }
        })
    }

    function buildListViewTable(allProjects, due_date, priority, status) {
        let listView = $('#list-view')

        console.log(allProjects)
        let tableHTML = ` <table class='table'>
        <th>
        </th>
        <th>
        </th>
        <th>
            Due Date
            <span id='due_date_arrows'>`


        if (due_date == 'desc' || due_date == '')
            tableHTML += `<i id="due-date-arrow-up" class="fas fa-arrow-up">up</i>`
        else
            tableHTML += `<i id="due-date-arrow-down" class="fas fa-arrow-down">down</i>`

        tableHTML += `  </span></th>
            <th>
            Priority
           
            <span id='priority_arrows'>`

        if (priority == 'High' || priority == '')

            tableHTML += `<i id="priority-arrow-up" class="fas fa-arrow-up">up</i>`
        else
            tableHTML += `<i id="priority-greyed-arrow-up" class="fas fa-arrow-down">greyed-up</i>`

        tableHTML += `
          </span></th>  <th>
            Status
         
            <span id='status_arrows'>`
        if (status == 'Completed' || status == "")
            tableHTML += `<i id="status-arrow-up" class="fas fa-arrow-up">up</i>`
        else
            tableHTML += `<i id="status-greyed-arrow-up" class="fas fa-arrow-up">greyed-up</i>`

        tableHTML += `</span></th></tr>`


        allProjects.forEach(project => {
            project_id = project['project_id']
            project_name = project['project_name']
            project_due_date = project['due_date']
            project_status = project['status']
            allPhases = project['phases']


            tableHTML += `<tr data-project_id=${project_id}>
            <th>
            </th>
            <th>
           Project ${project_name}
            </th>
         
           
            </tr>`


            allPhases.forEach(phase => {
                phase_id = phase['phase_id'];
                phase_name = phase['phase_name'];
                phase_due_date = phase['due_date']

                tasks = phase['tasks']




                tableHTML += `<tr>
          
            <th>
            ${phase_name}
            </th>
            <th>
            <i class='fa fa-add add_task_icon rest_other' data-phase_id=${phase_id}>ADD</i>
            </th>
           </tr>
          
               
          
                `

                tasks.forEach(task => {
                    console.log(task)

                    task_id = task['task_id'];
                    task_name = task['task_name'];
                    task_due_date = task['due_date']
                    task_prioirty = task['task_priority']
                    task_status = task['status']
                    subtasks = task['subtasks']

                    console.log(task_status)
                    tableHTML += `
               

                
                <tr data-task_id=${task_id}>
                <td>
                <i class='fa fa-ban delete_task_icon rest_other' data-task_id=${task_id}>delete</i>`

                    if (task_status == 'Completed' || task_status == 'completed') {
                        tableHTML += ` <i class="fa-solid fa-check green task-tick rest ">tick</i>`

                    } else {
                        tableHTML += ` <i class="fa-solid fa-check task-tick rest ">untick</i>`

                    }

                    tableHTML += `
                <i class="fa fa-add add_subtask_icon rest_other" data-task_id=${task_id}>ADD</i>
                <i class="fa-solid fa-arrow-right expandable-row" data-task_id=${task_id}>expand</i></td>
            <td data-task_id=${task_id}>
            <span class='task_name_span' data-task_id=${task_id}>
            ${task_name}
            </span>
            <i class="fa fa-edit task_name_edit rest_other" data-task_id=${task_id}>edit</i>
            <input class='task_name_input' type='text' value="${task_name}" data-task_id=${task_id}>
            </td>
            <td>
            <input type='date' value="${task_due_date}" data-task_id="${task_id}" class='task_due_date_edit rest'>
            </td>
              <td>
              <select class='task_priority rest' data-task_id="${task_id}" >
              `


                    if (task_prioirty == 'Low') {
                        tableHTML += `<option value="Low" selected>Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>`
                    } else if (task_prioirty == 'Medium') {
                        tableHTML += `<option value="Low">Low</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="High">High</option>`

                    } else if (task_prioirty == 'High') {
                        tableHTML += `<option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                <option value="High" selected>High</option>`
                    }

                    tableHTML += `</select>
                </td>
                <td>

                <select class='task_status rest' data-task_id="${task_id}" >
              `


                    if (task_status == 'Unstarted') {
                        tableHTML += `<option value="Unstarted" selected>Unstarted</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>`
                    } else if (task_status == 'In Progress') {
                        tableHTML += `<option value="Unstarted" selected>Unstarted</option>
                    <option value="In Progress" selected>In Progress</option>
                    <option value="Completed">Completed</option>`

                    } else if (task_status == 'Completed') {
                        tableHTML += `<option value="Unstarted" selected>Unstarted</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed" selected>Completed</option>`
                    } else {
                        tableHTML += `<option value="Unstarted" selected>Unstarted</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed" selected>Completed</option>`
                    }

                    tableHTML += `</select></td>

                </tr>`

                    subtasks.forEach(subtask => {

                        console.log(subtask)
                        subtask_id = subtask['subtask_id'];
                        subtask_name = subtask['subtask_name'];
                        subtask_due_date = subtask['due_date'];
                        subtask_status = subtask['subtask_status']

                        tableHTML += `<tr data-subtask_id=${subtask['subtask_id']} data-task_id=${task_id} class='hidden-row subtask_row'>
              <td>&nbsp  &nbsp 
                <i class='fa fa-ban delete_subtask_icon rest_other' data-subtask_id=${subtask_id}>delete</i>
                `

                        if (subtask_status == 'Completed' || subtask_status == 'completed') {
                            tableHTML += ` <i class="fa-solid fa-check green subtask-tick">tick</i>`

                        } else {
                            tableHTML += ` <i class="fa-solid fa-check subtask-tick">untick</i>`

                        }


                        tableHTML += `<td data-subtask_id=${subtask_id}>
            <span class='subtask_name_span' data-subtask_id=${subtask_id}>
            ${subtask_name}
            </span>
            <i class="fa fa-edit subtask_name_edit rest_other" data-subtask_id=${subtask_id}>edit</i>
            <input class='subtask_name_input' type='text' value="${subtask_name}" data-subtask_id=${subtask_id}>
            </td>
                  <td>
            <input type='date' value="${subtask_due_date}" data-subtask_id="${subtask_id}" class='subtask_due_date_edit  rest'>
</td>

<td>
</td>

<td><select data-subtask_id=${subtask['subtask_id']} class='subtask_status'>`

                        if (subtask_status == 'Unstarted') {
                            tableHTML += `<option value="Unstarted" selected>Unstarted</option>
  <option value="In Progress">In Progress</option>
  <option value="Completed">Completed</option>`
                        } else if (subtask_status == 'In Progress') {
                            tableHTML += `<option value="Unstarted" selected>Unstarted</option>
  <option value="In Progress" selected>In Progress</option>
  <option value="Completed">Completed</option>`

                        } else if (subtask_status == 'Completed') {
                            tableHTML += `<option value="Unstarted" selected>Unstarted</option>
  <option value="In Progress">In Progress</option>
  <option value="Completed" selected>Completed</option>`
                        } else {
                            tableHTML += `<option value="Unstarted" selected>Unstarted</option>
  <option value="In Progress">In Progress</option>
  <option value="Completed" selected>Completed</option>`
                        }

                        tableHTML += ` </select></td></tr>`

                    })

                })




            });
        })

        tableHTML += `</table>`

        listView.html(tableHTML);


        changeTaskName(project_id);
        changeSubtaskName(project_id)
        expandTaskRow(project_id)
        changeTaskDueDate(project_id);
        changeTaskPriorty();
        changeSubtaskDueDate(project_id)
        taskTick(project_id);
        subtaskTick(project_id);
        changeTaskStatus(project_id)
        changeSubtaskStatus(project_id);
        addTask(project_id);
        addSubtask(project_id);
        deleteTask(project_id);
        deleteSubtask(project_id);
        Filter(project_id);
        Restrict()
    }

    function Restrict() {
        if (auth_level == 1) {
            $(".rest_other").hide()
            $(".rest").prop("disabled", true)
        }
    }

    function Filter(project_id) {
        $('#due_date_arrows').click(function(e) {
            if ($(e.target).attr('id') == 'due-date-arrow-up')
                getProjectDetails('asc');
            else
                getProjectDetails('desc');

        })


        $('#status_arrows').click(function(e) {

            if ($(e.target).attr('id') == 'status-arrow-up')



                getProjectDetails('', '', 'Unstarted')

            else
                getProjectDetails('', '', 'Completed')

        })


        $('#priority_arrows').click(function(e) {
            if ($(e.target).attr('id') == 'priority-arrow-up')
                getProjectDetails('', 'Low', '')

            else
                getProjectDetails('', 'High', '')

        })
    }

    function deleteSubtask(project_id) {
        $('.delete_subtask_icon').click(function() {

            task_id = $(this).data('subtask_id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this item. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                // If the user confirms deletion, show a success message
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../actions/subtasks/delete_subtask.php',
                        data: {
                            subtask_id

                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'success') {



                                getProjectDetails(project_id)

                            } else {

                            }

                        }
                    })
                }
            });



        })
    }


    function deleteTask(project_id) {
        $('.delete_task_icon').click(function() {

            task_id = $(this).data('task_id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this item. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                // If the user confirms deletion, show a success message
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../actions/tasks/delete_task.php',
                        data: {
                            task_id

                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'ok') {



                                getProjectDetails(project_id)

                            } else {

                            }

                        }
                    })
                }
            });



        })
    }

    function addSubtask(project_id) {

        $(".add_subtask_icon").on("click", function() {
            $("#add_subtask_modal").modal("show");

            let currentTask_id = $(this).data("task_id");


            $('#add_subtask_modal_btn_').on('click', function(e1) {


                let new_subtask_name = $("#add_subtask_input").val();



                $.ajax({
                    url: '../actions/subtasks/add_subtasks.php',
                    data: {
                        currentTask_id,
                        new_subtask_name

                    },
                    type: 'POST',
                    success: function(response) {
                        if (response.status == 'success') {
                            $("#add_subtask_modal").modal("hide");


                            getProjectDetails(project_id)

                        } else {

                        }

                    }
                })
            })
        })
    }

    function addTask(project_id) {

        $(".add_task_icon").on("click", function() {
            $("#add_task_modal").modal("show");

            let phase_id = $(this).data("phase_id");


            $('#add_task_modal_btn').on('click', function(e1) {


                let task_name = $("#add_task_input").val();



                $.ajax({
                    url: '../actions/tasks/add_task.php',
                    data: {
                        phase_id,
                        task_name

                    },
                    type: 'POST',
                    success: function(response) {
                        if (response.status == 'ok') {
                            $("#add_task_modal").modal("hide");


                            getProjectDetails(project_id)

                        } else {



                        }

                    }
                })
            })
        })
    }


    function changeSubtaskStatus(project_id) {
        $(".subtask_status").on("change", function() {
            subtask_id = $(this).closest('tr').data('subtask_id');
            subtask_status = $(this).val()

            $.ajax({
                url: '../actions/subtasks/change-status.php',
                data: {
                    subtask_id,
                    subtask_status

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'success') {


                        getProjectDetails(project_id)


                    } else {



                    }

                }
            })

        })
    }

    function subtaskTick(project_id) {
        let subtask_completed;
        $(".subtask-tick").on("click", function() {
            subtask_id = $(this).closest('tr').data('subtask_id');
            if ($(this).hasClass('green')) {
                subtask_completed = 0
            } else {
                subtask_completed = 1
            }
            $.ajax({
                url: '../actions/subtasks/change-status.php',
                data: {
                    subtask_id,
                    subtask_completed

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'success') {

                        getProjectDetails(project_id)


                    } else {



                    }

                }
            })

        })
    }

    function changeSubtaskName(project_id) {
        let subtaskNameInputEls = $(".subtask_name_input")
        let subtaskNameEditEls = $('.subtask_name_edit')



        subtaskNameInputEls.hide()

        subtaskNameEditEls.on('click', function(e) {
            e.stopPropagation()
            let subtask_id = $(this).data('subtask_id')

            let subtaskNameInput = $(`.subtask_name_input[data-subtask_id="${subtask_id}"]`);
            let subtaskNameEdit = $(`.subtask_name_edit[data-subtask_id="${subtask_id}"]`);
            let subtaskNameSpan = $(`.subtask_name_span[data-subtask_id="${subtask_id}"]`);



            subtaskNameInput.show()
            subtaskNameEdit.hide()
            subtaskNameSpan.hide()

            subtaskNameInput.addClass('isActive')

            subtaskNameInput.focus()

            $(document).on('click', function(e1) {


                if (!subtaskNameInput.is(':focus') && subtaskNameInput.hasClass('isActive')) {
                    let editSubtaskNameInput = subtaskNameInput.val()



                    $.ajax({
                        url: '../actions/subtasks/edit_subtask_name.php',
                        data: {
                            subtask_id,
                            editSubtaskNameInput

                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'success') {
                                $(document).off('click')
                                subtaskNameInput.removeClass('isActive')
                                getProjectDetails(project_id)

                            } else {



                            }

                        }
                    })
                }
            })
        })
    }

    function changeTaskStatus(project_id) {
        $(".task_status").on("change", function() {
            task_id = $(this).closest('tr').data('task_id');
            task_status = $(this).val()

            $.ajax({
                url: '../actions/tasks/edit_task_details_by_sidebar.php',
                data: {
                    task_id,
                    task_status

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'ok') {


                        getProjectDetails(project_id)


                    } else {



                    }

                }
            })

        })
    }

    function taskTick(project_id) {
        let task_completed;
        $(".task-tick").on("click", function() {

            if (auth_level != 1) {


                task_id = $(this).closest('tr').data('task_id');
                if ($(this).hasClass('green')) {
                    task_completed = 0
                } else {
                    task_completed = 1
                }
                $.ajax({
                    url: '../actions/tasks/edit_task_details_by_sidebar.php',
                    data: {
                        task_id,
                        task_completed

                    },
                    type: 'POST',
                    success: function(response) {
                        if (response.status == 'ok') {


                            getProjectDetails(project_id)


                        } else {



                        }

                    }
                })

            }
        })
    }

    function changeSubtaskDueDate(project_id) {
        $('.subtask_due_date_edit').on('change', function(e) {
            subtask_id = $(this).closest('tr').data('subtask_id');
            st_new_date = $(this).val();



            $.ajax({
                url: '../actions/subtasks/edit_subtask_times.php',
                data: {
                    subtask_id,
                    st_new_date

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'ok') {


                        getProjectDetails(project_id)


                    } else {



                    }

                }
            })

        })
    }

    function changeTaskPriorty() {
        $('.task_priority').on('change', function(e) {
            task_id = $(this).data('task_id')
            task_priority = $(this).val();


            $.ajax({
                url: '../actions/tasks/edit_task_details_by_sidebar.php',
                data: {
                    task_id,
                    task_priority

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'ok') {



                    } else {



                    }

                }
            })

        })
    }

    function changeTaskDueDate(project_id) {
        $('.task_due_date_edit').on('change', function(e) {
            task_id = $(this).data('task_id')
            task_due_date = $(this).val();


            $.ajax({
                url: '../actions/tasks/edit_task_due_date.php',
                data: {
                    task_id,
                    task_due_date

                },
                type: 'POST',
                success: function(response) {
                    if (response.status == 'success') {


                        getProjectDetails(project_id)

                    } else {



                    }

                }
            })

        })
    }

    function expandTaskRow(project_id) {
        $('.expandable-row').click(function() {
            var task_id = $(this).data('task_id');
            $('.hidden-row[data-task_id="' + task_id + '"]').slideToggle();
        });
    }

    function changeTaskName(project_id) {
        let taskNameInputEls = $(".task_name_input")
        let taskNameEditEls = $('.task_name_edit')



        taskNameInputEls.hide()

        taskNameEditEls.on('click', function(e) {
            e.stopPropagation()
            let task_id = $(this).data('task_id')

            let taskNameInput = $(`.task_name_input[data-task_id="${task_id}"]`);
            let taskNameEdit = $(`.task_name_edit[data-task_id="${task_id}"]`);
            let taskNameSpan = $(`.task_name_span[data-task_id="${task_id}"]`);



            taskNameInput.show()
            taskNameEdit.hide()
            taskNameSpan.hide()

            taskNameInput.addClass('isActive')

            taskNameInput.focus()

            $(document).on('click', function(e1) {


                if (!taskNameInput.is(':focus') && taskNameInput.hasClass('isActive')) {
                    let task_name = taskNameInput.val()



                    $.ajax({
                        url: '../actions/tasks/edit_task_details_by_sidebar.php',
                        data: {
                            task_id,
                            task_name

                        },
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'ok') {
                                $(document).off('click')
                                taskNameInput.removeClass('isActive')
                                getProjectDetails(project_id)

                            } else {



                            }

                        }
                    })
                }
            })
        })
    }
</script>