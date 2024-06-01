<?php 
require('../actions/check-login.php');
require('../class/division.class.php');
require('../class/employee.class.php');
$division=new Division();
$employee=new Employee();
$allDiv=$division->getallDivisions();


if (isset($_GET['division_id'])) {
    // Get the value of the 'id' parameter
    $division_id = $_GET['division_id'];

    
} else{

    $division_id=$division->getDivisionID();
}

$allDivDetails=$division->getDivisionDetailsByID($division_id);
$nonDivEmps=$employee->getNonDivEmps($division_id);

$divEmps=$employee->getEmployeesByDivID($division_id);


$divisionIDJson=json_encode($division_id);

$nonDivEmpsJson=json_encode($nonDivEmps);




?>
<!DOCTYPE html>
<html lang="en">

<head>
<style>
.table{
    border:0px;
    opacity: .9;

}


.options-dropdown {
    display: none !important;
    position: absolute;
    right: 0;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1;
}


.options-dropdown-alter {
    
    display: flex !important;
    position: absolute;
    right: 0;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1;
}
.option-item {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.option-item:hover {
    background-color: #f1f1f1;
}

#division{
margin-right:auto;
}

h1{
    font-size:30px !important;
    font-style: italic;
    color:red !important;
    font-weight: 300 !important;
}
h2{
    font-size:25px !important;
}


.nav-two {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    
    border-bottom: 1px solid black;
    width:90%;
  }
  
  .nav-two li {
    float: left;
    border-left:1px solid black;
  }
  
  .nav-two-item:hover{
      background-color: grey;
  }
  
  .nav-two-item a {
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none !important;
  }
  
  .nav-two-item a:hover{
  color:black !important;
      
  }
</style>
 <?php require('../common/head.php'); ?>
</head>

<body>
    <!-- modal -->
   
   <?php
    require('../elements/modals/division.php');
    require('../elements/modals/addEmployeeToDiv.php') ?>

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
           <?php require('../common/navbar.php'); 
           ?>
          

            <!-- Navbar End -->
          <div class='add-select'>
          <div id="division">
    <h1>DIVISIONS</h1>

    <h2><?php echo $allDivDetails["division_name"] ?></h2>
    <i class="fa-solid fa-ban edit">edit</i>

    <i class="fa-solid fa-ban delete">delete</i>
    <div id="divisions-options-dropdown" class="options-dropdown">
        <div class="option-item">Edit</div>
        <div class="option-item" onclick="deleteDivision()">Delete</div>
    </div>
</div>

<select id="divisionSelect" name="divisionSelect" class='dropdown-thick'>
<?php foreach($allDiv as $k=>$v){?>
    <option class="divOption" value="<?php echo $v['division_id'] ?>"  <?php echo $v['division_id'] == $division_id ? "selected" : ""; ?>>

<?php echo $v['division_name'] ?>

</option>
   <?php } ?>
</select>

<div align='right' style='margin:10px 0px 10px 10px'>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addEmployeeToDivModal">
    ADD MEMBER
  </button>
            </div>
            <!-- content-->
            <div align='right' style='margin:10px 0px 10px 10px'>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addDivModal">
    ADD DIVISION
  </button>
            </div>
          </div>

           <div class='container-fluid'>
            <div class="row">
                <div class="col-lg-12">
<?php   require('../elements/divisions-navbar.php'); 

require('../elements/divisions-members.php'); 
require("../elements/divisions-overview.php")?>

         
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
<script>


var currentDivID=<?php echo $divisionIDJson; ?>;
var nonDivEmps=<?php echo $nonDivEmpsJson; ?>;
var employeeToDiv=[];

console.log(currentDivID)
console.log(nonDivEmps)


//after re-populating the nondivempscontainer, the 


function colorEmpsCards() {
    $(".employee-filter").on("click", function() {
    let employeeID = $(this).attr('id'); // Use data method to get the data-employee_id attribute

    // Check if employeeID is in the array
    let index = employeeToDiv.indexOf(employeeID);

    if (index !== -1) {
        // If employeeID is in the array, remove it
        employeeToDiv.splice(index, 1);
        $(this).removeClass('employee-filter-alter');
        $(this).addClass('employee-filter');
    } else {
        // If employeeID is not in the array, add it
        employeeToDiv.push(employeeID);
        $(this).removeClass('employee-filter');
        $(this).addClass('employee-filter-alter');
    }
    console.log(employeeToDiv)
});
    }



function populateNonDivEmpsModal(divArray){
    nonDivEmpsContainer=$("#nonDivEmpsContainer")
nonDivEmpsContainer.empty()
    divArray.forEach(employee => {
        
   
    
        var nonDivEmployee =`
            <div class="employee-filter white" id="${employee.employee_id}">
                <span>(pp)${employee.employee_fn} ${employee.employee_ln}</span>
                <span class='division-name'>${employee.division_name}</span>
            </div>
        `;

        
    nonDivEmpsContainer.append(nonDivEmployee);
    })
colorEmpsCards()
}




$(document).ready(()=>{

    
    $('#membersBtn').click(function(){
        $("#overviewContent").hide();
       $("#divTable").show();
    })

    $('#overviewBtn').click(function(){
        $("#overviewContent").show();
        $("#divTable").hide();


    })

$("#division-options-icon").click(function() {
    let options=$("#division-options-dropdown")
options.removeClass("options-dropdown")
options.addClass("options-dropdown-alter")
})
 
//checking to see if memebers or overview is included in the url, and set the appropriate button as active accordingly
    if (window.location.search.includes("members")) {
       
    $("#members").addClass("active");
    $("#overview").removeClass("active");

} else if (window.location.search.includes("overview")) {
    $("#overview").addClass("active");
    $("#members").removeClass("active");

    

} 

//populating the Add-Emp-To-Div Modal
populateNonDivEmpsModal(nonDivEmps)


$('#employee-searcher').on('input', function() {
    var input = $(this).val().toLowerCase();

    if (input === '') {
        populateNonDivEmpsModal(nonDivEmps);
    } else {
        // Filter employees based on the search term
        var filteredNonDivEmps = nonDivEmps.filter(function(employee) {
            return employee.employee_fn.toLowerCase().includes(input) || 
                   employee.employee_ln.toLowerCase().includes(input);
        });

        // Use the filteredNonDivEmps array as needed (e.g., update UI, etc.)
 

    console.log(filteredNonDivEmps)
    // Display the results
  populateNonDivEmpsModal(filteredNonDivEmps);
  filteredNonDivEmps = nonDivEmps;
}
})

    $("#divisionSelect").on("change",function(){
        let divID=$(this).val();
        if(divID!=currentDivID){
            window.location.href="http://localhost/www/C-PeRA/admin/pages/divisions-members.php?division_id="+divID+"&members"

        
    }})



$(".delete").on("click",function(){
    Swal.fire({
    title: 'Are you sure?',
   
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DC3545',
    cancelButtonColor: '#2E2E30',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
}).then((result) => {
    if (result.isConfirmed) {
        // Handle the deletion logic here
        $.ajax({
      url: "../actions/divisions/delete_division.php",
      data: {
     currentDivID
        
      },
      type: 'POST',
      success: function (result) {
        Swal.fire({
title: 'Success!',
text: result.message,
icon: 'Success'

})
    
    window.location.href="http://localhost/www/C-PeRA/admin/pages/divisions-members.php?"
        
    }
})
    }})
})




    $(".empRow").on('click', function() {
     
    let employeeID = $(this).attr('id');
    window.location = "http://localhost/www/C-PeRA/admin/pages/employee-details.php?id=" + employeeID;
});


$('#addEmployeeToDivForm').on('submit',function(e){
    console.log(currentDivID);
    e.preventDefault();
    if(employeeToDiv.length > 0){
        $.ajax({
      url: $(this).attr('action'),
      data: {
     currentDivID,
        employeeToDiv
      },
      type: 'POST',
      success: function (result) {
          // Handle success
       
          if (result.status == 'ok') {
            Swal.fire({
title: 'Success!',
text: result.message,
icon: 'success',
confirmButtonText: 'Cool'
}).then(()=>{
    window.location.href="http://localhost/www/C-PeRA/admin/pages/divisions-members.php?division_id="+currentDivID+"&members"
    

})
    }
}
        })
    }
})

  
  $("#addDivForm").on('submit', function (e) {
  e.preventDefault();

  var form = $(this).serialize();

  $.ajax({
      url: $(this).attr('action'),
      data: form,
      type: 'POST',
      success: function (result) {
          // Handle success
       
          if (result.status == 'ok') {
              // rest of your code...

              Swal.fire({
title: 'Success!',
text: result.message,
icon: 'success',
confirmButtonText: 'Cool'
}).then(()=>{
    window.location.href="http://localhost/www/C-PeRA/admin/pages/divisions-members.php?division_id="+result.division_id+"&members"
    

})
              
          }
          else{
            
            Swal.fire({
title: 'OOPS!',
text: result.message,
icon: 'fail',
confirmButtonText: 'Try argain'
})
          }
        }, 
         error: function (request, status, error) {
       alert(error.message);
      },
  });
});

$(".colorPickerInput").spectrum({
        preferredFormat: "hex", // You can choose the color format (hex, rgb, rgba, hsl, etc.)
        showInput: true, // Show the color input box
        showPalette: true, // Show the color palette
        showSelectionPalette: true, // Show the recently selected colors
        chooseText: "Select", // Text for the "Select" button
        cancelText: "Cancel", // Text for the "Cancel" button
        palette: [
            ["#ffffff", "#000000", "#ff0000", "#00ff00", "#0000ff"], // Example color palette
            // Add more colors as needed
        ],
    });



    })
    

    

    $('.edit').on('click',function(){
     

     $('#editDivModal').modal('show');   

 })

 
      
       

        $("#searchIcon").click(function() {
            var searchTerm = $(".search-input").val();
            alert("Performing search for: " + searchTerm);
        });

        
        $(".add").on('click', function() {
    $('#addEmployeeToDivModal').modal('show');   
   currentDivID = $(this).data('division_id');

})

    $('#editDivForm').submit(function(e) {
        
     
        e.preventDefault();

            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data:form.serialize(),
                  
                success: function(response) {
                          
                  
            if (response.status === 'ok') {
            
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: 'button btn btn-primary app_style'
                            }
                        }).then(function() {
                            window.location.reload();
                        });
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'warning',
                            title: response.message,
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: 'button btn btn-primary app_style'
                            }
                        });
                    } 
           
        },
    })

    


})
            
  
    
</script>
