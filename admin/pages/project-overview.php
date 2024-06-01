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
            border: 5px solid black !important;
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

        #Completed-btn:hover {
            background-color: blue;
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
</head>

<body>
    <!-- modal-end -->
    <?php require('../common/sidebar.php'); ?>

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
            require('../elements/modals/addProjectManager.php') ?>

            <!-- Navbar End -->





            <div class='container-fluid'>
                <div class="row">
                    <div class="col-lg-12">
                        <?php require("../elements/projects-nav.php"); ?>
                        <button class='btn btn-lg btn-danger rest' id="delete_project_btn">Delete Project</button>
                        <div id='project_details' class='scrollbale'>
                            <div>
                                <h2>Project Description</h2>
                                <textarea id='project_description' rows="4" cols="70">
                            </textarea>
                            </div>

                            <div>
                                <br>
                                <label for="project_due_date">Due Date:</label>
                                <input type='date' name='project_due_date' class='due-date rest' id='project_due_date'>



                            </div>

                            <div>
                                <br>
                                <h2>Project Name:</h2>

                                <div id='project_name_div2'>
                                    <span id='project_name_span'></span>
                                    <i class="fa fa-edit rest-other" id="project_name_edit">edit</i>
                                </div>

                                <div id="project_name_div">


                                </div>

                            </div>

                            <div id='project_phases'>
                                <h2>Project Phases:<i class="fa fa-add rest-other" id="addPhaseIcon">add</i></h2>
                                <div id='project_phases_container'>

                                </div>
                            </div>

                        </div>

                        <div id='right_sidebar' class='scrollbale'>
                            <div>
                                <h2>What's the status:</h2>
                                <div id='status' class='rs-item'>


                                </div>
                            </div>

                            <div id='project_managers'>
                                <h2>Project Managers </h2>
                                <div id='project_managers_container' class='rs-item'>

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
    var projectNameEdit = $("#project_name_edit")
    var projectNameSpan = $("#project_name_span")
    var projectNameDiv2 = $('#project_name_div2')






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


        $("#right_sidebar").show()



        openAddPhaseModal(project_id) //
        getProjectDetails(project_id);
        changePhaseDueDate(project_id)
        changeProjectDueDate(project_id)
        deleteProject()


    })

    function deleteProject() {
        $("#delete_project_btn").click(function() {

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this item!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Here you can perform the delete action

                    $.ajax({
                        url: '../actions/projects/delete_project.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            project_id,

                        },
                        success: function(result) {
                            if (result.status == 'ok')
                                window.location = 'projects.php'
                        },

                    })
                }

            })
        })
    }







    function getProjectDetails(project_id) {
        let statusDiv = $("#status")
        let projectNameSpan = $("#project_name_span")
        let projectNameDiv = $("#project_name_div")
        let projectDescInput = $("#project_description")
        let projectDueDateInput = $("#project_due_date")
        let projectManagers = $("#project_managers")
        let projectManagersContainer = $("#project_managers_container")
        let projectPhasesContainer = $("#project_phases_container")

        let projectManagersHTML
        let phasesHTML = ''


        statusDiv.html('')
        projectPhasesContainer.html('')

        $.ajax({
            url: '../actions/projects/get_project_details_for_overview.php',
            type: 'POST',
            dataType: 'json',
            data: {
                project_id,

            },
            success: function(result) {
                let project_status = result.details[0].status;
                let project_desc = result.details[0].project_description
                let project_due_date = result.details[0].due_date
                let project_name = result.details[0].project_name
                let project_managers = result.managers
                let phases = result.phases




                console.log(result)

                let statusDivHTML =
                    `    <button class='btn btn-lg status-btn' id="on-track" value="On Track"><span class='circle'></span>On Track</button>


<button class='btn btn-lg status-btn' id="at-risk" value="At Risk"><span class='circle'></span>At Risk</button>

<button class='btn btn-lg status-btn' id="off-track" value="Off Track"><span class='circle'></span>Off Track</button>

<button class='btn btn-lg status-btn' id="Completed-btn" value="Completed"><span class='circle'></span>Completed</button>



`

                let projectNameDivHTML =
                    `  
                             <input type='text' id='project_name_input'>
                             `

                //managers
                project_managers.forEach(manager => {
                    let managersHTML = `

           

                    <div class='emp_card'>
                    <i class='remove-manager' data-user_id="${manager['user_id']}" class=fa fa-ban'>
                    Remove</i>
   <i class='fa fa-star'>star</i>`

                    if (manager['employee_fn'] != null) {
                        managersHTML += `${manager['employee_fn']} `
                    }
                    if (manager['employee_ln'] != null) {
                        managersHTML += `${manager['employee_ln']} `
                    }
                    if (manager['admin_fn'] != null) {
                        managersHTML += `${manager['admin_fn']} `
                    }
                    if (manager['admin_ln'] != null) {
                        managersHTML += `${manager['admin_ln']} `
                    }

                    managersHTML += `</div>
                    
                `


                    projectManagersHTML += managersHTML
                });


                projectManagersHTML += `<button id='addManagerBtn' class='btn btn-small btn-dark rest'>
                    ADD</button>`



                //Phases

                phases.forEach(phase => {
                    let percent = phase['percent']
                    let color_code = phase['color_code']
                    var phase_due_date = phase['due_date']
                    let phase_id = phase['phase_id']
                    let phase_status = phase['phase_status']

                    console.log(phase)


                    let phaseHTML = `<div class='phase' data-phase_id_two='${phase_id}'>
                         <span>${phase['phase_name']}</span>
                         <i class='fa fa-edit edit-phase'  data-edit_phase_id='${phase['phase_id']}'
                         data-edit_phase_name='${phase['phase_name']}' 
                         data-edit_phase_color='${phase['color_code']}'>edit</i>`


                    if (phase_status == 'Completed') {
                        phaseHTML += ` <span><i class='fa fa-tick green phase_status' data-status_phase_id="${phase_id}">Tick</i></span>`
                    } else {
                        phaseHTML += ` <span><i class='fa fa-tick phase_status'>unTick</i></span>`

                    }
                    phaseHTML += `<div class="progress-bar-container">
  <div class="progress-bar" data-phase_id=${phase['phase_id']}></div>
</div>
<span class='percent'>${percent}%</span>
<span class='fa fa-ban delete-phase' data-delete_phase_id='${phase['phase_id']}'>delete</span>
<form class='phase-due-date-form'>
<label>Due Date:</label> 
<input type='date' value='${phase_due_date}' class='phase-due-date due-date' name='phase_due_date' data-old_due='${phase_due_date}'
data-phase_due_id='${phase_id}'>
<input type='text' value='${phase_id}' hidden name='phase_id'>
</form>
</div>`






                    projectPhasesContainer.append(phaseHTML)


                    let bar = $('[data-phase_id=' + phase['phase_id'] + ']');
                    console.log(bar)

                    bar.css('width', percent + '%');
                    bar.css('background-color', color_code)
                })


                projectManagersContainer.html(projectManagersHTML)

                openAddManagerModal(project_id)
                removeManager(project_id)


                statusDiv.html(statusDivHTML)

                projectDescInput.html(project_desc)

                projectNameSpan.html(project_name)
                projectNameSpan.val(project_name)


                projectNameDiv.html(projectNameDivHTML)

                projectDueDateInput.val(project_due_date)

                projectDueDateInput.prop('disabled', false);

                if (project_status == 'On Track') {

                    $("#on-track").addClass('clicked')
                    $("#on-track").css('background-color', 'green')

                } else if (project_status === 'At Risk') {

                    $("#at-risk").addClass('clicked');
                    $("#at-risk").css('background-color', 'yellow')

                } else if (project_status === 'Off Track') {
                    $("#off-track").addClass('clicked')
                    $("#off-track").css('background-color', 'red')

                } else if (project_status == 'Completed') {
                    $("#Completed-btn").addClass('clicked')
                    $("#Completed-btn").css('background-color', 'blue')


                    projectDueDateInput.prop('disabled', true);
                }

                let projectNameInput = $("#project_name_input");
                projectNameInput.hide()
                changeProjectName(project_id, projectNameInput)
                changeProjectStatus(project_id)
                changeProjectDesc(project_id, projectDescInput)
                openEditPhaseModal(project_id)
                deletePhase(project_id)
                // addPhase(project_id)
                $('.due-date').attr('min', getCurrentDate());

                changePhaseStatus(project_id);

                LockIfCompleted(project_status)
                PhaseLock();
            }
        })
    }

    function LockIfCompleted(project_status) {


        var rest = $('.rest');

        var rest_other = $('.rest-other');

        if (project_status == 'Completed') {

            var rest = $('.rest');

            var rest_other = $('.rest-other');

            rest_other.each(function() {
                // Do something with each sibling element
                $(this).hide()


            });

            rest.each(function() {
                // Do something with each sibling element


                $(this).prop('disabled', true)


            });
        } else {


            rest_other.each(function() {
                // Do something with each sibling element
                $(this).show()


            });

            rest.each(function() {
                // Do something with each sibling element


                $(this).prop('disabled', false)


            });
        }

    }

    function PhaseLock() {


        // Select all elements with the class 'green' and 'phase_status'
        var phases = $(".green.phase_status");

        // Loop through each element with class 'green' and 'phase_status'
        phases.each(function() {
            // Get the value of 'phase_id' data attribute for the current element
            var phase_id = $(this).data('status_phase_id');

            // Select elements with data-edit_phase_id equal to 'phase_id'
            var edits = $("[data-edit_phase_id='" + phase_id + "']");

            // Hide each element with data-edit_phase_id equal to 'phase_id'
            edits.hide();

            // Select elements with data-delete_phase_id equal to 'phase_id'
            var deletes = $("[data-delete_phase_id='" + phase_id + "']");

            // Hide each element with data-delete_phase_id equal to 'phase_id'
            deletes.hide();

            var due_date = $("[data-phase_due_id='" + phase_id + "']");

            due_date.prop('disabled', true);
        });

    }

    function changePhaseStatus(project_id) {
        $(".phase_status").click(function() {
            let phase_id = $(this).closest('div').data('phase_id_two');

            let status;
            if ($(this).hasClass('green')) {
                status = 'In Progress';

            } else {
                status = 'Completed';
            }

            $.ajax({
                url: '../actions/phases/edit_phase_details.php',
                data: {
                    status,
                    phase_id
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {

                    getProjectDetails(project_id);
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })

        })
    }

    function getCurrentDate() {
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var year = today.getFullYear();
        return year + '-' + month + '-' + day;
    }


    function changeProjectDueDate(project_id) {

        $("#project_due_date").on('change', function() {

            let project_due_date = $(this).val()




            $.ajax({
                url: '../actions/projects/change_due_date.php',
                data: {
                    project_due_date,
                    project_id
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    toastr.success(result.message_project);
                    toastr.success(result.message_phases);
                    toastr.success(result.message_tasks);
                    toastr.success(result.message_subtasks);
                    getProjectDetails(project_id);
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })
        })

    }

    function changePhaseDueDate(project_id) {

        $(document).on('change', '.phase-due-date', function() {

            let newDate = $(this).val()
            let phase_id = $(this).data("phase_id")
            let phaseElement = $(this)
            let old_due = $(this).data("old_due")


            let form = $(this).closest('form').serialize();
            console.log(form)

            $.ajax({
                url: '../actions/phases/change_due_date.php',
                data: form,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.status == 'ok') {
                        getProjectDetails(project_id);
                        toastr.success(result.message_phase);
                        toastr.success(result.message_tasks);
                        toastr.success(result.message_subtasks);
                    } else {
                        toastr.warning(result.message_error);

                        phaseElement.val(old_due)


                    }
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })
        })

    }

    function removeManager(project_id) {

        $(".remove-manager").on("click", function() {
            let user_id = $(this).data("user_id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../actions/projects/remove_manager.php',
                        data: {
                            user_id
                        },
                        type: 'POST',
                        success: function(result) {
                            getProjectDetails(project_id);
                        },
                        error: function(request, status, error) {
                            toastr.warning(request.responseText);
                        }

                    })

                }
            })
        })
    }


    function deletePhase(project_id) {

        $(".delete-phase").on("click", function() {
            let deletePhaseID = $(this).data("delete_phase_id");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../actions/phases/delete_phase.php',
                        data: {
                            deletePhaseID
                        },
                        type: 'POST',
                        success: function(result) {
                            getProjectDetails(project_id);
                        },
                        error: function(request, status, error) {
                            toastr.warning(request.responseText);
                        }

                    })

                }
            })
        })

    }

    function openAddManagerModal(project_id) {
        $('#addManagerBtn').on("click", function() {
            let addManagerModal = $("#add-project-manager-modal")
            let managersContainer = $('#modalProjectManagersContainer')
            let managersHTML = ''

            addManagerModal.modal('show');
            $.ajax({
                url: '../actions/divisions/get_managers_division.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    project_id
                },
                success: function(result) {
                    let managers = result.managers

                    managers.forEach(manager => {
                        let fn = manager.employee_fn;
                        let ln = manager.employee_ln;
                        let pp = manager.pp;
                        let e_id = manager.employee_id

                        let managerHTML =
                            `   <div class='emp_card div_managers' data-employee_id='${e_id}'>
            
   <i class='fa fa-star'>star</i>
${pp}   ${fn} ${ln}
</div>`
                        managersHTML += managerHTML

                    });

                    managersContainer.html(managersHTML);

                    $(".div_managers").on('click', function() {
                        let e_id = $(this).data('employee_id')

                        $.ajax({
                            url: '../actions/projects/add_manager.php',
                            data: {
                                e_id,
                                project_id
                            },
                            type: 'POST',
                            success: function(result) {
                                if (result.status == 'success') {
                                    $("#add-project-manager-modal").modal("hide");
                                    getProjectDetails(project_id);
                                } else {
                                    toastr.warning(result.message)
                                }
                            },
                            error: function(request, status, error) {
                                toastr.warning(request.responseText);
                            }

                        })

                    })
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })
        })
    }

    function openAddPhaseModal(project_id) {
        $("#addPhaseIcon").on('click', function() {
            $("#addPhaseProjectID").val(project_id)
            $("#add-phase-modal").modal("show");

        })
        $("#add_phase_submit").on("click", function() {
            let form = $("#addPhaseForm").serialize()
            $.ajax({
                url: '../actions/phases/add_phase.php',
                data: form,
                type: 'POST',
                success: function(result) {
                    $("#add-phase-modal").modal("hide");
                    getProjectDetails(project_id);
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })

        })
    }



    function openEditPhaseModal(project_id) {
        $('.edit-phase').on('click', function() {
            var phase_name = $(this).data('edit_phase_name');
            var phase_id = $(this).data('edit_phase_id');
            var phase_color = $(this).data('edit_phase_color');


            //    var phase_color = $(this).data('edit_phase_color');

            $('#edit-phase-modal').modal('show');
            $('#editPhaseName').val(phase_name)
            $('#phaseIDInput').val(phase_id)
            $("#editPhaseColor").val(phase_color)

        })

        $("#edit_phase_submit").on("click", function() {

            let form = $('#editPhaseForm').serialize();
            $.ajax({
                url: '../actions/phases/edit_phase_details.php',
                data: form,
                type: 'POST',
                success: function(result) {
                    getProjectDetails(project_id);
                    $("#edit-phase-modal").modal('hide');
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })



        })
    }

    function changeProjectStatus(project_id) {



        $(".status-btn").click(function() {

            var clickedButton = $(this);
            let project_status = $(this).val();

            $.ajax({
                url: '../actions/projects/change_project_details.php',
                data: {
                    project_id,
                    project_status
                },
                type: 'POST',
                success: function(result) {
                    getProjectDetails(project_id)
                },
                error: function(request, status, error) {
                    toastr.warning(request.responseText);
                }

            })
        });
    }

    function changeProjectName(project_id, projectNameInput) {

        $(document).on("click", function(e) {

            if ($(e.target).is(projectNameEdit)) {
                projectNameDiv2.hide();
                projectNameInput.show();
                projectNameInput.focus();
                projectNameInput.addClass('isActive');
                projectNameInput.val(projectNameSpan.val());
                e.stopPropagation();
            }
            // Start a timer to execute code after a delay

            if (projectNameInput.hasClass("isActive") && !$(e.target).hasClass("isActive") && !$(e.target).is(projectNameEdit)) {
                projectNameInput.removeClass('isActive');
                $(document).off("click")

                let project_name = projectNameInput.val();

                $.ajax({
                    url: '../actions/projects/change_project_details.php',
                    data: {
                        project_id: project_id,
                        project_name: project_name
                    },
                    type: 'POST',
                    success: function(result) {
                        projectNameDiv2.show();
                        getProjectDetails(project_id);

                    },
                    error: function(request, status, error) {
                        toastr.warning(request.responseText);
                    }
                });
            }
        })
    }






    function changeProjectDesc(project_id, projectDesc) {


        $(document).on("click", function(e) {


                if ($(e.target).is(projectDesc)) {
                    projectDesc.addClass('isActive')

                }

                if (!$(e.target).hasClass('isActive') && projectDesc.hasClass('isActive')) {
                    projectDesc.removeClass('isActive')
                    $(document).off("click")


                    project_desc = projectDesc.val()
                    $.ajax({
                        url: '../actions/projects/change_project_details.php',
                        data: {
                            project_id,
                            project_desc
                        },
                        type: 'POST',
                        success: function(result) {

                            getProjectDetails(project_id)

                        },
                        error: function(request, status, error) {
                            toastr.warning(request.responseText);
                        }

                    })
                }
            }

        )
    }



    // $(".status-btn").click(function() {
    //     var clickedButton = $(this);
    //     let project_status = $(this).val();
    //     $.ajax({
    //         url: '../actions/projects/change_status.php',
    //         data: {
    //             project_id,
    //             project_status
    //         },
    //         type: 'POST',
    //         success: function(result) {
    //             getProjectDetails(project_id)
    //         },
    //         error: function(request, status, error) {
    //             toastr.warning(request.responseText);
    //         }

    //     })
    // });
</script>