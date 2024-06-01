<?php


require('../actions/check-login.php');

require('../class/project.class.php');

require('../class/division.class.php');





$project = new Project();
$division = new Division();


$allProjects = $project->getAllProjects();
$perc = $project->getProjectPercentageArray();




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('../common/head.php'); ?>

    <style>
        .three-quarters-div {
            width: 75%;
            /* Three-fourths of the viewport width */
            height: 75%;
            /* Three-fourths of the viewport height */
            border: 1px solid black;
            /* For visualizing the div */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .greyed-out {
            opacity: 0.5;
            /* Adjust opacity to make elements appear greyed out */
            cursor: not-allowed;
            /* Change cursor to indicate unclickable */
        }


        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            /* full height of the viewport */
        }

        .proj-table th {
            border: none
        }

        .proj-table {
            border: 1px black;
            border-radius: 10px;

        }

        #addProjectBtn {
            margin-top: 150px;
            border-radius: 20px;
            padding: 8px
        }

        #createProjectBtn {
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: 0;

        }

        .progress-container {
            width: 100%;
            background-color: #ccc;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .progress-bar {
            width: 0;
            height: 8px;
            background-color: #4CAF50;
            text-align: center;
            line-height: 30px;
            color: red;
        }

        .percentage {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .d-flex button {
            background-color: #DC3545 !important;
        }

        .active {
            background-color: #DC3545;
        }
    </style>
</head>

<body>

    <?php require("../elements/modals/projects.php");
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





            <div class="row">

                <div class="col-lg-12">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div align='right' style='margin:10px 0px 10px 10px'>

                            <button type="button" class="btn btn-danger rest-btn" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                                CREATE PROJECT
                            </button>
                        </div>
                        <!-- Add any other content or elements you want to appear on the right side of the button -->
                    </div>
                    <div id='projects_details_view'>

                    </div>
                </div>
            </div>
        </div>

        <!-- Content End -->


        <!-- Back to Top -->
    </div>

    <!-- JavaScript Libraries -->

    <?php require('../common/script.php') ?>
    <!-- Template Javascript -->

</body>

</html>

<script>
    $(document).ready(function() {
        getProjectsDetails();
        createProject();

        if (auth_level != 3) {
            $(".rest-btn").prop('disabled', true).addClass('greyed-out');
            $(".rest-input").prop('disabled', true).addClass('greyed-out');
        }

    })

    function createProject() {
        $("#createProjectForm").on("submit", function(e) {
            e.preventDefault()

            let form = $(this).serialize();

            $.ajax({
                url: '../actions/projects/create_project.php',
                data: form,
                type: 'POST',
                success: function(result) {
                    // Handle success

                    if (result.status == 'ok') {
                        // rest of your code...

                        window.location.reload();

                    }


                }
            })
        })
    }


    function getProjectsDetails(due_date_sort = 'asc', completion_filter = '') {


        $.ajax({
            url: '../actions/projects/get_the_projects_details.php',
            data: {
                filters: {
                    'due_date_sort': due_date_sort,
                    completion_filter
                }
            },
            type: 'POST',
            success: function(result) {
                // Handle success

                if (result.status == 'success') {
                    // rest of your code...

                    details = result.details
                    console.log(result)
                    buildProjectsDetails(details, due_date_sort, completion_filter);

                }
            }
        })
    }


    function buildProjectsDetails(details, due_date_sort, completion_filter) {

        let detailsHTML = ` <table class='proj-table'>

<tr class='unclickable'>
<th>`

        if (completion_filter == 'true') {
            detailsHTML += `<span  id='completion_filter' class='tick'>
Completed
</span>
 <i class='fa fa-tick'>tick</i>`

        } else {
            detailsHTML += `<span  id='completion_filter'>
Completed
</span>`

        }
        detailsHTML += `</span></th>

<th>
</th>

<th>
</th>

<th>
sort by:

<span>Due Date</span> 
<span  id='due_date_sort'>`

        if (due_date_sort == 'asc')
            detailsHTML += ` <i class='fa fa-arrow-down'>down</i>`
        else
            detailsHTML += `<i class='fa fa-arrow-up'>up</i>`

        detailsHTML += `
</th>

</tr>
`

        if (details.length > 0) {
            details.forEach(detail => {


                detailsHTML += `
<tr class="proj-table-row" data-project_id=${detail['project_id']}>
<th>
${detail['project_name']}
</th>


<th>    

<div class="progress-container">
<span id='progressPercent' class='progressPercent percentage' data-project_id="${detail['project_id']}" align='center'>${detail['percentage']}</span>
<div class="progress-bar" data-project_id="${detail['project_id']}"></div>
</div>

</th>

<th>${detail['status']}</th>
<th>${detail['due_date']}</th>


</tr>`
                var percentage = details['percentage']
                var progressBar = $(`.progress-bar[data-project_id="${details['project_id']}"]`);
                var percentTextElement = $(`.progressPercent[data-project_id="${details['project_id']}"]`);
                // Check if progressBar exists before setting its width

                if (progressBar.length > 0) {
                    progressBar.css('width', '0%');
                }

            })

        }
        detailsHTML += `</table>`


        if (details.length == 0)
            detailsHTML += '<p>no projects</p>'

        let detailsView = $("#projects_details_view")

        detailsView.html(detailsHTML)
        // let percentage=percentageArray[1];

        var percentage = details['percentage']
        var progressBar = $(`.progress-bar[data-project_id="${details['project_id']}"]`);
        var percentTextElement = $(`.progressPercent[data-project_id="${details['project_id']}"]`);
        // Check if progressBar exists before setting its width
        if (progressBar.length > 0) {
            progressBar.css('width', '0%');
        }

        projectSelect()
        filters()
    }

    function projectSelect() {
        $('.proj-table-row').click(function() {
            // Get the id attribute value of the clicked row
            var projectId = $(this).data('project_id');

            // Construct the URL with the project id and navigate to it
            window.location.href = 'http://localhost/www/C-PeRA/admin/pages/project-gantt.php?project_id=' + projectId;
        });
    }


    function filters() {


        $("#due_date_sort").click(function(e) {
            let due_date_sort
            if ($(e.target).hasClass('fa-arrow-up'))
                due_date_sort = 'asc';
            else
                due_date_sort = 'desc';


            getProjectsDetails(due_date_sort);

        })

        $('#completion_filter').click(function(e1) {
            let completion_filter
            console.log($(e1.target))
            if ($(e1.target).hasClass('tick'))
                completion_filter = 'false';
            else
                completion_filter = 'true';

            getProjectsDetails('desc', completion_filter);
        })
    }
</script>