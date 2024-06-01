
<div class="modal" id="createProjectModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Project</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form method="post" action="../actions/admins/create_project.php" id='createProjectForm'>
        <label for="projectNameInput">
          <input type="text" id="projectNameInput" name="projectNameInput" placeholder="Enter Project Name">
        </label>
<br>
<br>
         
        <button type="submit" class="btn btn-danger">CREATE PROJECT</button>
</form>
    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>