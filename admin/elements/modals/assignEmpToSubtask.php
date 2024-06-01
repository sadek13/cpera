<div class="modal r-s" id="assignEmpModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <input type="text" id="employee_searcher" placeholder="Search...">
                <i class="fas fa-search search-icon" id="searchIcon"></i>

                <select id="assignEmps_divSelector" name="assignEmps_divSelector">
                    <?php foreach ($allDivs as $div) {
                        var_dump($div) ?>
                        <option value="<?php echo $div['division_name'] ?>" id="<?php echo $div['division_id'] ?>">
                            <?php echo $div['division_name'] ?></option>

                    <?php    } ?>
                </select>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="../actions/subtasks/assign_emp_to_subtask.php" id='assignEmpForm'>

                    <div id="nonAssignedEmpsContainer">

                    </div>

                    

                </form>
            </div>
            <button type="submit" id="assignEmpBtn" class="btn btn-danger">ASSIGN</button>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal r-s" id="docsModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Register User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table id="docsTable" class="table table-striped">

                </table>
            </div>
        </div>
    </div>
</div>