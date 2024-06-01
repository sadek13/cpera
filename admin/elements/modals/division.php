
<div class="modal" id="addDivModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ADD DIVISION</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form method="post" action="../actions/divisions/add_division.php" id='addDivForm'>
        <label for="addDivInput">
          <input type="text" id="addDivInput" name="addDivInput" placeholder="Enter Division Name">
        </label><br><br>

       <!-- <lable for="colorPickerInput" value="Division Color"> Division Color:
        <input type="text" class="colorPickerInput" name="colorCode"/>
       </lable> -->
        <br><br>
        <button type="submit" class="btn btn-danger">ADD DIVISION</button>

</form>
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<div class="modal" id="editDivModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">EDIT DIVISION</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form method="post" action="../actions/divisions/update_division.php" id='editDivForm'>
        <label for="editDivInput">
          <input type="text" id="editDivInput" name="editDivInput" value="<?php echo $allDivDetails['division_name']?>">
          </label><br><br>

          <!-- <label for="editColorCode">
          <input type="text" id="editColorCode" name="editColorCodeInput" class='colorPickerInput'>
          </label><br><br>
           -->
          <input type="hidden" id="editDivID" name='div_id' value="<?php echo $division_id?>">
        
        <button type="submit" class="btn btn-danger">Save</button>
</form>
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

