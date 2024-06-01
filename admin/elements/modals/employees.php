<div class="modal" id="registerEmployeesModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Register User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-center " style="height: 70px;">
                    <button class="p-2 m-2 bg-info text-dark shadow rounded-2" id="regEmpBtn">Employee</button>
                    <button class="p-2 m-2 bg-info text-dark shadow rounded-2" id="regAdminBtn">Admin</button>
                </div>

                <form action="../actions/employees/register_employee.php" id="registerEmployeeForm" method="POST">
                    <div class="input-group mb-3" hidden>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">ID</span>
                        </div>
                        <input type="text" class="form-control input-control" label="ID" name="id">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">First Name</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="First Name" name="first-name">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Last Name</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Last Name" name="last-name">
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Username</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Username" name="username">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Password</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Password" name="password">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">E-mail</span>
                        </div>
                        <input type="email" class="form-control input-control" aria-label="E-mail" name="email">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">Phone Number</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Description" name="phone">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Division</label>
                        </div>
                        <select name="div_id" id="inputGroupSelect02" class="form-control input-control">
                            <?php foreach ($allDivs as $k => $v) { ?>
                                <option value="<?php echo $v["division_id"] ?>" <?php //echo ($v["division_name"] == $productDetails[0]["category"]) ? "selected" : ""; 
                                                                                ?>>
                                    <?php echo $v["division_name"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>




                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">Position</span>
                        </div>
                        <input type="text" class="form-control input-control" name="position">
                    </div>






                    <button type="submit" class="btn btn-danger">ADD EMPLOYEE</button>
                </form>


                <form action="../actions/admins/register_admin.php" id="registerAdminForm" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-3" hidden>
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">ID</span>
                        </div>
                        <input type="text" class="form-control input-control" label="ID" name="id">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">First Name</span>
                        </div>
                        <input type="text" class="form-control input-control" name="admin_fn">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Last Name</span>
                        </div>
                        <input type="text" class="form-control input-control" name="admin_ln">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Username</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Username" name="username">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Password</span>
                        </div>
                        <input type="text" class="form-control input-control" aria-label="Password" name="password">
                    </div>



                    <button type="submit" class="btn btn-danger">ADD ADMIN</button>
                </form>


            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>
            </form> -->


        </div>
    </div>
</div>