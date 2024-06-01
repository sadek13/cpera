
<div class="modal" id="addEmployeeToDivModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      <input type="text" id="employee-searcher" placeholder="Search...">
            <i class="fas fa-search search-icon" id="searchIcon"></i>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form method="post" action="../actions/employees/add_employee_to_div.php" id='addEmployeeToDivForm'>
      
      <div id="nonDivEmpsContainer">

    </div>
        
        <button type="submit" class="btn btn-danger modalAddButton">ADD</button>

</form> 
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>