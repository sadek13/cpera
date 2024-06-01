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