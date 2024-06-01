<?php 
require('../actions/check-login.php');
require('../class/employee.class.php');
require('../class/division.class.php');
require('../class/user.class.php');



$user=new User();
$division=new Division();
$employee=new Employee();

if (isset($_GET['employee_id'])) {
    // Get the value of the 'id' parameter
    $employee_id = $_GET['employee_id'];

    $employee_id_json=json_encode($employee_id);

    $employeeDetails=$employee->getEmployeeDetailsbyID($employee_id);

    $user_id=$employeeDetails['user_id'];

    $employeeUserDetails=$user->getUUserDetailsByUserId($user_id);

    $allDivs=$division->getAllDivisions();

    $idImages=$employee->getIDImagesByEmployeeID($employee_id);
  
} 


?>
<!DOCTYPE html>
<html lang="en">

<head>
 <?php require('../common/head.php'); ?>

 <style>
    body {
    margin: 0;
    overflow: hidden;
}

.portrait-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.portrait {
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
}

.zoomed {
    visibility: visible;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: rgba(0, 0, 0, 0.7);
}
.undis{
    
    visibility: hidden;
}

.back-face{
    display: inline-block;
}
</style>
</head>

<body>

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


            <!-- content-->
    
<?php require('../elements/edit-employee-form.php'); ?>
        <!-- Content End -->

</div>
        <!-- Back to Top -->


    <!-- JavaScript Libraries -->
  
<?php require('../common/script.php')?>
    <!-- Template Javascript -->
  
</body>

</html>

<script>
    $(document).ready(function (e) {

        var employee_id=<?php echo $employee_id_json; ?>;

    $('#viewImage').on('click',function (e) {
        e.preventDefault()

        $('#idImage').toggleClass('zoomed');
        $('#idImage').removeClass('undis');
    });

    $(document).click(function (event) {
        const idImage = $('#idImage');

        // Check if the click is outside the zoomed portrait
        if (!idImage.is(event.target) && idImage.hasClass('zoomed')) {
            idImage.removeClass('zoomed');
        }
    });

    $('#editEmployeeForm').on('submit',function(e){
        e.preventDefault();

  var form = $(this).serialize();

  $.ajax({
      url: $(this).attr('action'),
      data: form,
      type: 'POST',
      success: function (result) {
        if(result.status=='ok'){
        Swal.fire({
title: 'Success!',
text: result.message,
icon: 'success',
confirmButtonText: 'Cool'
}).then(()=>{
    window.location.reload();
})
       console.log(result)
    }
else{
    Swal.fire({
title: 'ERROR!',
text: result.message,
icon: 'error',
confirmButtonText: 'Try Again!'
}).then(()=>{
    window.location.reload();
})
       console.log(result)
}}
})
    })
})

</script>


