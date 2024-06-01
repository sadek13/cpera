
       <div>
<form action="../actions/employees/edit_employee.php" id="editEmployeeForm" method="POST" enctype="multipart/form-data">
                            <!-- <div class="input-group mb-3" hidden>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ID</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="id" aria-label="ID" name="id"  value="<//?php $employeeDetails['employee_ID'] ?>">
                                </div>    -->
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">First Name</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="First Name" aria-label="First Name" name="first-name"  value="<?php echo $employeeDetails['employee_fn'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Last Name</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="Last Name" aria-label="Last Name" name="last-name"  value="<?php echo $employeeDetails['employee_ln'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Username</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="Username" aria-label="Username" name="username"  value="<?php echo $employeeUserDetails['username'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Password</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="Password" aria-label="Password" name="password"  value="<?php echo $employeeUserDetails['password'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">E-mail</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="E-mail" aria-label="E-mail" name="email"  value="<?php echo $employeeDetails['email'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">Phone Number</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="Description" aria-label="Description" name="phone" aria-describedby="basic-addon2" value="<?php echo $employeeDetails['phone'] ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Division</label>
                                    </div>
                                    <select name="division_id" id="inputGroupSelect02" class="form-control input-control">
                                        <?php foreach ($allDivs as $k => $v) { ?>
                                            <option value="<?php echo $v["division_id"] ?>" <?php echo ($v["division_id"] == $employeeDetails["division_id"]) ? "selected" : ""; ?>>
                                                <?php echo $v["division_name"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                          

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">Position</span>
                                    </div>
                                    <input type="text" class="form-control input-control" placeholder="Material" aria-label="material" name="employee_position" aria-describedby="basic-addon2" value="<?php echo $employeeDetails['employee_position'] ?>">
                                </div>

                           

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">Profile Picture</span>
                                    </div>
                                    <input type="file" class="form-control input-control"ria-label="weight" name="pp" aria-describedby="basic-addon2">
                                </div>

                                <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id ?>" />
           
                                
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" value="submit"> Submit</button>
                                </div>
                    
            
</form>

                                        </div>