<?php require('../elements/modals/employees.php');
    require('../elements/modals/addSubtask.php');
    require('../elements/modals/editSubtaskName.php');
    require('../elements/modals/assignEmpToSubtask.php');
    require('../common/sidebar.php'); ?>
    <!-- modal-end -->
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->

        <!-- Spinner End -->


        <!-- Sidebar Start -->

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require('../common/navbar.php'); ?>
            <!-- Navbar End -->





            <div class='container-fluid'>
                <div class="row">
                    <div class="col-lg-12">

                        <h1>Project <?php echo $projectDetails["project_name"] ?></h1>
                        <?php require("../elements/projects-nav.php");
                        require('../elements/modals/docs.php'); ?>


                        <!-- <div id="overviewContent">

                </div> -->

                        <div id="ganttContent">
                            <div id="gantt_here">

                            </div>
                        </div>

                        <!-- <div id="listContent">

</div> -->



                        <div id="right_sidebar">


                            <div class="sb_item">
                                <h2 id="taskNameHeader">Task:</h2>

                                <div class="inline" id="sb_taskName">
                                </div>
                                <p class="inline"><label>Due Date:<input type="date" id="taskDueDate" name="taskDueDate"></label></p>

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

                                                <option value="unstarted"><i class="fa-solid fa-circle"></i>Unstarted</option>
                                                <option value="in prograss"><i class="fa-solid fa-circle"></i>In Progress</option>
                                                <baroption value="paused"><i class="fa-solid fa-circle"></i>Paused</option>
                                                    <option value="done"><i class="fa-solid fa-circle"></i>Done</option>


                                            </select>
                                        </form>
                                    </div>
                                </h2>

                            </div>



                            <div class="sb_item">
                                <h2 id=''>Subtasks</h2>
                                <i class="fa fa-plus" id="addSubtaskIcon">ADD SUB</i>

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
                            <input type="date" class="new_date">
                            <div id="overlay"></div>




                            <!-- <div align='right' style='margin:10px 0px 10px 10px'>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerEmployeeModal">
    ADD EMPLOYEE
  </button>
            </div> -->


                            <!-- Bootstrap dropdown converted to select element -->


                        </div>
                    </div>
                </div>

                <!-- Content End -->


                <!-- Back to Top -->
            </div>
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

                    //                     const myDatePicker = new HotelDatepicker($(".due_date"),{
                    //       // date format
                    //       format: "YYYY-MM-DD",
                    //       infoFormat: "YYYY-MM-DD",
                    //       ariaDayFormat: "dddd, MMMM DD, YYYY",
                    //       // separator displayed between date strings
                    //       separator: " - ",
                    //       // or monday 
                    //       startOfWeek: "sunday", // Or monday
                    //       // start/end dates
                    //       startDate: new Date(),
                    //       endDate: false,
                    //       // min/max nights required to select a range of dates
                    //       minNights: 1,
                    //       maxNights: 0,
                    //       // allow ranges that are multiples of minNights only
                    //       minNightsMultiple: false,
                    //       // true: the second date must be after the first date
                    //       selectForward: false,
                    //       // disabled dates
                    //       disabledDates: [],
                    //       noCheckInDates: [],
                    //       noCheckOutDates: [],
                    //       disabledDaysOfWeek: [],
                    //       noCheckInDaysOfWeek: [],
                    //       noCheckOutDaysOfWeek: [],
                    //       // allows the checkout on a disabled date or not
                    //       enableCheckout: false,
                    //       // determine whether to close the date range picker on click outside
                    //       preventContainerClose: false,
                    //       // container to hold the date range picker
                    //       container: "",
                    //       // animation speed
                    //       animationSpeed: ".5s",
                    //       // show a tooltip when hovering a date
                    //       // or:
                    //       // hoveringTooltip: function(nights, startTime, hoverTime) {
                    //       //   return nights;
                    //       // }
                    //       hoveringTooltip: true, 
                    //       // auto close the date range picker when a date range is selected 
                    //       autoClose: true,
                    //       // show/hide the toolbar
                    //       showTopbar: true,
                    //       // or "bottom"
                    //       topbarPosition: "top",
                    //       // move both months when clicking on the next/prev month button
                    //       moveBothMonths: false,
                    //       // enable inline mode
                    //       inline: false,
                    //       // show the Clear button
                    //       clearButton: false,
                    //       // show the Submit button
                    //       submitButton: false,
                    //       // the name of the Submit button
                    //       submitButtonName: '',
                    //       // trigger a custom function to show extra text in day cells
                    //       // parameters: date, attributes
                    //       extraDayText: false,
                    //       // callback functions
                    //       onDayClick: false,
                    //       onOpenDatepicker: false,
                    //       onSelectRange: false,
                    // })
                    //                     //if right-sidebar is opened, it will be closed when somewhere outside the bar
                    // has been clicked 

                    $(document).on("click", function(e) {
                        if ((!$(e.target).closest("#right_sidebar").length && !$(e.target).closest(".r-s").length) && $("#right_sidebar").is(":visible")) {
                            $("#right_sidebar").hide();
                        }
                    });


                    $("#addSubtaskInput").hide()

                    $("#subtask-edit-submit").on('click', function() {
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

                        sidebar.css("right", "0"); // Open sidebar by setting right to 0
                        overlay.css("display", "none");

                        // let html=`<h1>${foundTask["task_name"]}</h1>`
                        //         //   `<div class="empCard">${foundTask`

                        // $("#sidebar").html(html);   


                        overlay.on("click", function() {
                            sidebar.css("right", "-70%"); // Close sidebar by setting right to -20%
                            overlay.css("display", "none"); // Hide overlay
                        });


                    });
                }





                function InitiateGantt(tasks) {


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
                        console.log(task[2]);
                        if (typeof task[2] === 'string') {
                            console.log(task[2]);
                        }


                        var newTask = {
                            id: parseInt(task[0]),
                            text: task[1],
                            start_date: task[2],
                            end_date: task[3] // Duration specified directly
                        };

                        console.log('task_', task[2])


                        newTasks.push(newTask); // Add the newTask object to the newTasks array
                    })
                    console.log(newTasks);
                    gantt.parse({
                        data: newTasks
                    });

                    var taskEle = gantt.getTaskNode(19)
                    console.log(taskEle);

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
                        url: '../actions/projects/get_tasks_details.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            project_id
                        },
                        success: function(response) {

                            InitiateGantt(response.tasks);
                        }
                    })
                }

                function getTaskDetailsForight_sidebar(task_id) {

                    let taskNameDiv = $("#sb_taskName")
                    let taskPrioritySelect = $("#taskPrioritySelect")
                    let taskStatusSelect = $("#taskStatusSelect")
                    let taskDescInput = $("#taskDescInput")
                    $.ajax({
                        url: '../actions/tasks/get_task_details_for_sidebar.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id
                        },
                        success: function(response) {
                            console.log(response[0])
                            let taskName = response[0].task_name
                            let taskPriority = response[0].task_priority
                            let taskStatus = response[0].status
                            let taskDesc = response[0].task_description
                            let taskNameInputHTML =
                                `<p class="taskNameParag" id="taskNameParag">
                                ${taskName}
                            <i class="fa fa-edit" id="editTaskName">Edit</i>
                                </p>
                                <form id="taskNameForm" action='../actions/tasks/update_task.php'>
                                <input hidden value="${taskName}" id="taskNameInput" type="text">
                                </form>`
                            taskNameDiv.html(taskNameInputHTML)

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



                            let taskNameInput = $('#taskNameInput')
                            updateTaskName();
                            taskNameAjax();
                            taskPriorityAjax(task_id);
                            taskStatusAjax(task_id);
                            taskDescAjax(task_id);


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

                    let todate = new Date();
                    $("#subtasksTable").html('');

                    $.ajax({
                        url: '../actions/tasks/get_subtask_details.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            task_id: task_id
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

                                if (subtask_status === "done") {
                                    checkSpan = "<i class='fa-solid fa-check'></i>";
                                } else {
                                    // Use a class instead of an ID for styling
                                    checkSpan = "<i class='fa-solid fa-check check-not-done'></i>";
                                }

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
          <i class="fa fa-edit subtask_name_edit_icon" data-subtask_id="${subtask_id}" data-subtask_name="${subtask_name}">edit</i></th>

           <th><label>Due Date:<input type="date" name="st_start_date" value="${due_date}" class='due_date'></label></th>    
                                `
                                due_date = new Date(due_date)
                                var differenceInMilliseconds = todate - due_date
                                var differenceInHours = differenceInMilliseconds / (1000 * 60 * 60);


                                console.log(due_date)
                                console.log(todate)

                                if (differenceInHours >= 24 && differenceInHours < 48) {
                                    subtasksHTML += `<th class='text-warning'>Due Tomorrow</th>`
                                } else if (differenceInHours < 24 && differenceInHours >= 0) {
                                    subtasksHTML += `<th class="above-warning">Due Today</th>`
                                } else if (differenceInHours < 0) {
                                    subtasksHTML += `<th class="text-danger">Past Due Date</th>`
                                }
                                subtasksHTML += `</tr>
                       
          <tr>
       
        <th><i class="fa-solid fa-person-circle-plus assignEmpIcon" data-subtask_id="${subtask_id}">assign</i></th>
            
        <th class="showAssignees">${assigneeImagesHTML}</th>
      
            <th> <i class="showDocsIcon fa-solid fa-file">Docs</i></th>
           
        </tr>
`



                                let docsHTML = `
                                    `
                                assignees.forEach(assignee => {
                                    docsHTML += ` < tr >
                                        <
                                        td >
                                        <
                                        img class = "small-image"
                                    src = "../images/pp/${assignee['pp']}" >
                                        <
                                        /td> <
                                        td >
                                        $ {
                                            assignee["assignee_fn"]
                                        }
                                    $ {
                                        assignee["assignee_ln"]
                                    } <
                                    td >
                                        `




                                    docs.forEach(doc => {
                                            if (doc['posted_by'] == assignee['assignee_id']) {
                                                docsHTML += ` < a > < img class = "small-image clickable docImg"
                                    src = "../images/docs/${doc['image_path']}" > < /a>`
                                            }
                                        }


                                    )

                                    docsHTML += `</td></tr>`



                                });

                                $("#docsTable").append(docsHTML);

                                $('.docImg').on('click', function() {
                                    window.open($(this).attr('src'), '_blank');
                                })
                                // Append the constructed HTML to the 'sb_subtasks' element
                                $("#subtasksTable").append(subtasksHTML);

                            })



                            $(".subtask_name_edit_icon").on('click', function() {


                                let subtask_name = $(this).data('subtask_name');
                                let subtask_id = $(this).data('subtask_id');

                                let editSubtaskInput = $("#editSubtaskInput")
                                let editSubtaskInput_ID = $("#editSubtaskInput_ID")
                                editSubtaskInput.val(subtask_name);
                                editSubtaskInput_ID.val(subtask_id);
                                $("#editSubtaskNameModal").modal("show")
                            })


                            $('#addSubtaskIcon').click(function(e) {
                                e.stopPropagation()
                                $("#addSubtaskInput").show()
                                $("#addSubtaskInput").addClass('isActive');

                                $(document).on('click', function(e2) {
                                    e2.preventDefault();

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
                                                $("#addSubtaskInput").hide()
                                                getSubtaskDetails(task_id)

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
                                assignEmpsAjax(subtask_id, empAssignArray);
                            });

                            $('.showDocsIcon').click(function() {
                                $('#docsModal').modal('show');
                            });

                            $('.showAssigneesIcon').click(function() {
                                $('#assigneesModal').modal('show');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX request failed:", xhr, status, error);
                            // You can add additional error handling code here, such as displaying an error message to the user.
                        }
                    });
                }

                function changeTaskDescription(task_id) {
                    $.ajax({
                        url: '../actions/subtasks/pphp',
                        data: {
                            subtask_id,
                            empAssignIDsArray
                        },
                        type: 'POST',
                        success: function(result) {
                            empAssignArray = [];
                            $('#assignEmpModal').modal('hide');

                            getSubtaskDetails(currentTask_id)
                        },
                        error: function(request, status, error) {
                            toastr.warning('re')

                        }
                    })
                }

                function assignEmpsAjax(subtask_id, empAssignIDsArray) {

                    $("#assignEmpBtn").on('click', function() {

                        $.ajax({
                            url: '../actions/subtasks/assign_emp_to_subtask.php',
                            data: {
                                subtask_id,
                                empAssignIDsArray
                            },
                            type: 'POST',
                            success: function(result) {
                                empAssignArray = [];
                                $('#assignEmpModal').modal('hide');

                                getSubtaskDetails(currentTask_id)
                            },
                            error: function(request, status, error) {
                                toastr.warning('re')

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


                function getNonAssEmps(subtask_id) {

                    $.ajax({
                        url: '../actions/tasks/get_unassigned_emps.php',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            subtask_id
                        },
                        success: function(result) {

                            populateNonAssEmpsModal(result);



                        }
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


                        nonAssignedEmpsContainer.append(nonAssignedEmployee);
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
                        e.preventDefault();
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