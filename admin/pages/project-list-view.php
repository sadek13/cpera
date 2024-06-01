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
}

$project_id_json = json_encode($project_id);

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

        /* Hide default file input */
        .file-upload {
            display: none;
        }

        /* Style the custom file upload button */
        .custom-file-upload {
            display: inline-block;
            background-color: grey;
            /* Button background color */
            color: white;
            /* Button text color */
            border-radius: 100px;
            /* Rounded corners */

            line-height: 30px;
            width: 50px;
            /* Adjust as needed */
            height: 30px;
            /* Padding */
            cursor: pointer;
            /* Cursor style */
        }

        /* Add padding to the icon */
        .custom-file-upload i {
            margin-right: 5px;
            /* Adjust as needed */
        }

        .small-image {
            width: 30px;
            /* Adjust as needed */
            height: 30px;
            /* Adjust as needed */
            border-radius: 50%;
            /* Makes the element round */
            background-color: #000;
            /* Background color */
            color: #fff;
            /* Text color */
            text-align: center;
            /* Center the text horizontally */
            line-height: 30px;
            /* Center the text vertically */
        }
    </style>
</head>

<body>
    <!-- modal-end -->
    <?php require('../common/sidebar.php');
    ?>

    <div class="container-fluid position-relative bg-white d-flex p-0">


        <!-- Content Start -->
        <div class="content zone">
            <!-- Navbar Start -->
            <?php require('../common/navbar.php');
            require('../elements/modals/editPhase.php');
            require('../elements/modals/addPhase.php');
            require('../elements/modals/addProjectManager.php');
            require('../elements/modals/add_task_and_sub.php');
            require("../elements/modals/assignEmpToSubtask.php")
            ?>

            <!-- Navbar End -->





            <div class='container-fluid'>
                <div class="row">
                    <div class="col-lg-12">
                        <?php require("../elements/projects-nav.php"); ?>

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
    var project_id = <?php echo $project_id_json; ?>;

    $(document).ready(function() {

        getProjectDetails(project_id, 'desc')


    })

    function getProjectDetails(project_id, due_date = 'desc', priority = '', status = '') {
        let listView = $('#list-view')
        console.log(status)

        $.ajax({
            url: '../actions/projects/get_project_details_for_list_view.php',
            data: {
                project_id,
                due_date,
                priority,
                status
            },
            type: 'POST',
            success: function(response) {
                if (response.status == 'success') {

                    buildListViewTable(response.allDetails, project_id, response.due_date, response.priority, response.task_status)

                } else {



                }

            }
        })
    }

    function buildListViewTable(allPhases, project_id, due_date, priority, status) {
        let listView = $('#list-view')

        console.log(allPhases)
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
                    assignees = subtask['assignees'];
                    docs = subtask['docdetails'];

                    tableHTML += `<tr data-subtask_id=${subtask['subtask_id']} data-task_id=${task_id} class='hidden-row subtask_row'>
                  
              <td>&nbsp  &nbsp 
    <i class="showDocsIcon">Info</i>

                <i class='fa fa-ban delete_subtask_icon rest_other' data-subtask_id=${subtask_id}>delete</i>
                `

                    if (subtask_status == 'Completed' || subtask_status == 'completed') {
                        tableHTML += ` <i class="fa-solid fa-check green subtask-tick">tick</i>`

                    } else {
                        tableHTML += ` <i class="fa-solid fa-check subtask-tick">untick</i>`

                    }

                    assignees.forEach(element => {
                        tableHTML += `<img src=../images/pp/${element['pp']} class='small-image'>`

                    });



                    tableHTML += `</td><td data-subtask_id=${subtask_id}>`


                    // docs.forEach(element => {
                    //     tableHTML += `<a href="../images/docs/${element['image_path']}" target="_blank"><img src="../images/docs/${element['image_path']}" class="small-image doc"></a>`;


                    // });


                    tableHTML += ` <span class='subtask_name_span' data-subtask_id=${subtask_id}>
            ${subtask_name}
            </span>
            <i class="fa fa-edit subtask_name_edit rest_other" data-subtask_id=${subtask_id}>edit</i>
            <input class='subtask_name_input' type='text' value="${subtask_name}" data-subtask_id=${subtask_id}>
            <label for="file-upload-${subtask_id}" class="custom-file-upload">
    <i class="fas fa-file"></i>Doc
</label>
<input id="file-upload-${subtask_id}" type="file" class='file-upload docs-up'/>

    <i class="fa fa-add assignEmpIcon">Assign</i>


           
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
        uploadDoc(project_id)
        openDocsModal(allPhases, project_id, due_date, priority, status)
        openAssignEmpsModal()
    }


    function openAssignEmpsModal() {
        $(".assignEmpIcon").click(function() {
            let subtask_id = $(this).closest('tr').data('subtask_id');
            $('#assignEmpModal').modal('show');
            getNonAssEmps(subtask_id)
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
                colorEmpsCards(st_id);
                Filter(st_id)
                changeAssignmentDivSearch(st_id)

            }
        })
    }

    function assignEmpsAjax(subtask_id, emps) {


        $("#assignEmpBtn").click(function() {
            $.ajax({
                url: '../actions/subtasks/assign_emp_to_subtask.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    emps,
                    subtask_id

                },
                success: function(result) {
                    getNonAssEmps(subtask_id)
                    getProjectDetails(project_id)

                }
            })

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

    function colorEmpsCards(subtask_id) {
        let empAssignArray = []

        $(".employee-filter").on("click", function() {
            let employeeID = $(this).data('employee_id');

            // Use data method to get the data-employee_id attribute
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
        });
        assignEmpsAjax(subtask_id, empAssignArray); //

    }



    function populateNonAssEmpsModal(empsArray) {
        console.log(empsArray)
        nonAssignedEmpsContainer = $("#nonAssignedEmpsContainer")
        nonAssignedEmpsContainer.empty()
        var nonAssignedEmployee = ''
        empsArray.forEach(employee => {


            nonAssignedEmployee = ` <div class="employee-filter white" data-employee_id="${employee.employee_id}">
<span>
<img class="small-image" src="../images/pp/${employee.pp}">
</span>
<span>${employee.employee_fn}</span>
</div>
`


        })
        nonAssignedEmpsContainer.html(nonAssignedEmployee) //;

    }



    function uploadDoc(project_id) {
        $('.file-upload').on('change', function() {
            // Get the selected file
            var subtask_id = $(this).closest('tr').data('subtask_id');

            var file = $(this)[0].files[0];

            // Create a FormData object and append the file to it
            var formData = new FormData();
            formData.append('doc', file);
            formData.append('subtask_id', subtask_id)

            // Make the AJAX request
            $.ajax({
                url: '../actions/subtasks/upload_doc.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle success response
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response

                }
            });
        });
    };

    function openDocsModal(allPhases, project_id, due_date, priority, status) {
        $(".showDocsIcon").on('click', function() {
            $("#docsModal").modal('show');

            let subtask_id = $(this).closest('tr').data('subtask_id')

            buildDocsModal(subtask_id, allPhases, project_id, due_date, priority, status)
        })
    }


    function buildDocsModal(subtask_id, allPhases, project_id, due_date, priority, status) {
        $("#docsTable").html('');

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

                    unAssignEmp(subtask_id, allPhases, project_id, due_date, priority, status)
                    deleteDoc(allPhases, project_id, due_date, priority, status);
                }
            }
        })
    }

    function deleteDoc(allPhases, project_id, due_date, priority, status) {
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
                            buildDocsModal(allPhases, project_id, due_date, priority, status)
                            getProjectDetails(project_id, due_date, priority, status)

                        }
                    }
                })

            })
        })
    }

    function unAssignEmp(subtask_id, allPhases, project_id, due_date, priority, status) {
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
                        buildDocsModal(allPhases, project_id, due_date, priority, status)
                        getProjectDetails(project_id, due_date, priority, status)


                    }
                }
            })
        })
    }


    function Restrict() {

        // Find all elements that have a sibling descendant <i> element with both classes 'subtask' and 'tick'
        var elements = $('.subtask-tick.green');



        // Loop through the found elements
        elements.each(function() {
            // Do something with each sibling element
            var tr = $(this).closest('tr');

            var rest = tr.find('.rest');

            var rest_other = tr.find('.rest_other');

var docsUp=tr.find('.docs-up');

docsUp.each(function() {
    $(this).prop('disabled',true);
})

            rest_other.each(function() {
                // Do something with each sibling element
                $(this).hide()


            });

            rest.each(function() {
                // Do something with each sibling element


                $(this).prop('disabled', true)


            });


        });





        if (auth_level == 1) {
            $(".rest_other").hide()
            
            $(".rest").prop("disabled", true)
        }
    }


    function Filter(project_id) {
        $('#due_date_arrows').click(function(e) {
            if ($(e.target).attr('id') == 'due-date-arrow-up')
                getProjectDetails(project_id, 'asc');
            else
                getProjectDetails(project_id, 'desc');

        })


        $('#status_arrows').click(function(e) {

            if ($(e.target).attr('id') == 'status-arrow-up')



                getProjectDetails(project_id, '', '', 'Unstarted')

            else
                getProjectDetails(project_id, '', '', 'Completed')

        })


        $('#priority_arrows').click(function(e) {
            if ($(e.target).attr('id') == 'priority-arrow-up')
                getProjectDetails(project_id, '', 'Low', '')

            else
                getProjectDetails(project_id, '', 'High', '')

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
                        task_name,
                        project_id

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