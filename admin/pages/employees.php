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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('../common/head.php'); ?>

    <link rel="stylesheet" href='../css/employees_table.scss' />
    <style>
        table th {
            color: white;
        }

        h1 {
            font-size: 40px !important;
            font-style: italic;
        }

        .active {

            background-color: #DC3545 !important;
        }

        .d-flex button {
            background-color: #DC3545 !important;
        }


        /* Change the link color to #111 (black) on hover */
    </style>
</head>

<body>

    <?php require('../elements/modals/employees.php'); ?>
    <!-- modal-end -->
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->

        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php require('../common/sidebar.php'); ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require('../common/navbar.php'); ?>
            <!-- Navbar End -->





            <div class="row">



                <h1>User Management</h1>
                <div align='right' style='margin:10px 0px 10px 10px'>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerEmployeesModal">
                        ADD EMPLOYEE
                    </button>
                </div>

                <?php require("../elements/employees-nav.php"); ?>

                <!-- Bootstrap dropdown converted to select element -->

                <div class="flex justify-content-end p-2" style=" right: 0;" id="empsTableMore">
                    <select class="form-control form-control-sm" id="divisionSelector">
                        <?php foreach ($allDivs as $k => $v) { ?>
                            <option value="<?php echo $v["division_id"] ?>"><?php echo $v["division_name"] ?></option>
                        <?php } ?>

                    </select>
                    <div id='empsTable'>

                    </div>
                </div>






                <?php require('../elements/admins-table.php');
                ?>
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
    let colorCodes = <?php echo $colorCodes; ?>;
    console.log(colorCodes)

    function populateEmpTable(filteredEmps, division_id) {
        let colorCode = colorCodes[division_id];

        let empTable = $('#empsTable');
        empTable.empty(); // Use .empty() to clear the existing content

        filteredEmps.forEach(element => {
            empTable.append(`
    <table class="table table-bordered table-hover" style="background-color:${colorCode}">
      

 

        <tr id="${element.employee_id}" class="employeeRow">
            <th>${element.fullname}</th>
            <th>${element.employee_position}</th>
        </tr>
</table>

    `);
        });



    }

    function filterAJAX(division_id) {
        $.ajax({
            url: '../actions/employees/filter_employees.php',
            data: {
                division_id
            },
            type: 'POST',
            success: function(result) {


                console.log(result);
                populateEmpTable(result, division_id);
                $('#employeesTable').DataTable()
                $('.employeeRow').on('click', function() {

                    let employeeID = $(this).attr('id');
                    window.location = "http://localhost/www/C-PeRA/admin/pages/create-project.php?id=" + employeeID

                })
            }
        })
    }

    function changeByURL() {
        let currentURL = window.location.href;

        if (currentURL.includes("employees")) {
            $("#employeesTable").show();
            $("#adminsTable").hide();
            $(this).addClass("active");

        } else if (currentURL.includes("admins")) {
            $("#employeesTable").hide();
            $("#adminsTable").show();
            $(this).addClass("active");

        }
    }

    $(document).ready(function() {
        let baseURL = "C:\\xampp\\htdocs\\www\\C-PeRA\\admin\\pages\\employees.php";

        $("#regEmpBtn").addClass("active");
        $("#empsBtn").addClass("active");

        $("#registerEmployeeForm").show();
        $("#registerAdminForm").hide();



        changeByURL();

        $("#regEmpBtn").on('click', function() {
            $("#registerEmployeeForm").show();
            $("#registerAdminForm").hide();

            $(this).addClass("active");

        });



        $("#regAdminBtn").on('click', function() {
            $("#registerEmployeeForm").hide();
            $("#registerAdminForm").show();
            $(this).addClass("active");
        })



        $("#empsBtn").on('click', function() {
            $("#empsTableMore").show();
            $("#adminsTable").hide();
            $(this).addClass("active");
            $("#adminsBtn").removeClass("active");
        });



        $("#adminsBtn").on('click', function() {
            $("#empsTableMore").hide();
            $("#adminsTable").show();
            $(this).addClass("active");
            $("#empsBtn").removeClass("active");



        })



        let division_id = $('#divisionSelector').val();

        filterAJAX(division_id);


        $('#divisionSelector').change(function() {
            let division_id = $(this).val();
            filterAJAX(division_id);
        });

        $("#registerAdminForm").on('submit', function(e) {

            e.preventDefault();

            var form = $(this).serialize();
            console.log(form);

            $.ajax({
                url: $(this).attr('action'),
                data: form,
                type: 'POST',
                success: function(result) {
                    // Handle success

                    if (result.status == 'ok') {
                        // rest of your code...

                        Swal.fire({
                            title: 'Success!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        }).then(() => {
                            window.location = "http://localhost/www/C-PeRA/admin/pages/employees.php?employees";
                        })

                    } else {

                        Swal.fire({
                            title: 'OOPS!',
                            text: result.message,
                            icon: 'fail',
                            confirmButtonText: 'Try argain'
                        })
                    }
                },
                error: function(request, status, error) {
                    alert(error.message);
                },
            });
        });





        $("#registerEmployeeForm").on('submit', function(e) {
            e.preventDefault();

            var form = $(this).serialize();
            console.log(form);

            $.ajax({
                url: $(this).attr('action'),

                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: form,
                success: function(result) {
                    // Handle success

                    if (result.status == 'ok') {
                        // rest of your code...

                        Swal.fire({
                            title: 'Success!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        }).then(() => {
                            window.location.reload();
                        })

                    } else {

                        Swal.fire({
                            title: 'OOPS!',
                            text: result.message,
                            icon: 'fail',
                            confirmButtonText: 'Try argain'
                        })
                    }
                },
                error: function(request, status, error) {
                    alert(error.message);
                },
            });
        });




    })



    $(document).on('click', '.employeeRow', function() {
        let employeeID = $(this).attr('id');
        window.location = "http://localhost/www/C-PeRA/admin/pages/employee-details.php?employee_id=" + employeeID;
    });
</script>