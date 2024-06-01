<?php 

require('../actions/check-login.php');
?>

<!DOCTYPE html> 
<html lang="en">

<head>
 <?php require('../common/head.php'); ?>

 <style>

.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh; /* full height of the viewport */
}

.grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* two columns */
    grid-template-rows: 1fr 1fr; /* two rows */
    gap: 10px;
    width: 80%; /* Adjust the width as per requirement */
    height: 80%; /* Adjust the height as per requirement */
}

.grid-item {
    border: 1px solid black;
    padding: 1  0px;
    /* Removing display: flex; as we don't need to center align items in the grid item */
}

.grid-item h1 {
    margin: 0; /* Remove default margin */
    white-space: normal; /* Allow text to wrap */
    /* Additional styles for h1 can be added here */
}

</style>
</head>

<body>
    <!-- modal -->

    <!-- modal-end -->
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        
        <!-- Spinner End -->


        <!-- Sidebar Start -->
      <?php require('../common/sidebar.php'); ?>
        <!-- Sidebar End -->


        <div class="content">
            <!-- Navbar Start -->
           <?php require('../common/navbar.php'); ?>
            <!-- Navbar End -->
      

            <!-- content start-->

            <div class="welcome-message">
            <h1>Welcome ...,</h1>
        </div>
            <div class="center-container">
        <div class="grid-container">
            <div class="grid-item">
                <h5>Tasks Due Today</h5>
</div>
<div class="grid-item">
                <h5>Projects</h5>
</div>
<div class="grid-item">
                <h5>Clients</h5>
</div>
<div class="grid-item">
                <h5>Employees</h5>
</div>
        </div>
    </div>

        <!-- Content End -->


        <!-- Back to Top -->
       
    </div>

    <!-- JavaScript Libraries -->
  
<?php require('../common/script.php')?>
    <!-- Template Javascript -->
  
</body>

</html>



