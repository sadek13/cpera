<div class="modal r-s" id="editSubtaskNameModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">EDIT DIVISION</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="../actions/subtasks/edit_subtask_name.php" id='editSubtaskNameForm'>
          <label for="editSubtaskInput">
            <input type="text" id="editSubtaskInput" name="editSubtaskNameInput">
          </label><br><br>

          <!-- <label for="editColorCode">
          <input type="text" id="editColorCode" name="editColorCodeInput" class='colorPickerInput'>
          </label><br><br>
           -->
          <input type="hidden" id="editSubtaskInput_ID" name='subtask_id'>
          </form>

          <button type="submit" id="subtask-edit-submit" class="btn btn-danger">Save</button>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>