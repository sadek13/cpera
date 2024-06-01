<?php 
require('../class/project.class.php');

$project=new Project();
// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Get the value of the 'id' parameter
    $id = $_GET['id'];

  $project_name=$project->getProjectName($id);
  
} 




?>
<?php require('../common/head.php') ?>


    <style>
        .btn-custom {
    background-color: black; /* Golden background */
    color: white; /* White text */
    border: none; /* Removes border, optional */
    margin-bottom:10px;
}

.btn-custom:hover {
    background-color: #d4af37; /* Slightly darker gold on hover, optional */
}
</style>
<div class="content">
    <?php require('../common/sidebar.php'); 

 require('../common/navbar.php');

 require('../elements/project-details-navbar.php');
   ?>

   
  

    </body>

    </html>


    <?php require('../common/script.php') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


    </script>
