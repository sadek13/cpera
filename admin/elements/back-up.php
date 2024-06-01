
<table id='employeesTable' class="table table-bordered table-hover">
      

 
    <thead>
<tr>
    <th>Name</th>
    <th>Division</th>
    <th>Position</th>
</tr>
    </thead>
    
    <?php foreach ($allEmployees as $k=>$v){ 
        $fullName=$employee->nameCombiner($v['employee_fn'],$v['employee_ln'])?>

<tr id=<?php echo $v['employee_id'] ?>>

     

 <td><?php echo $fullName ?></td>

 <td><?php echo $v['division_name'] ?></td>

 
 <td><?php echo $v['position'] ?></td>
 
      

</tr>
    
  

        <?php } ?>

</table>


