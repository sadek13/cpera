




<table class="table table-hover" id="divTable">
      

  <?php foreach ($divEmps as $k=>$v){ 
 ?>

    

<tr id="<?php echo $v['employee_id'] ?>" class="empRow">

     <th><?php echo $v['employee_fn'],$v['employee_ln'] ?></th>

     <th><?php echo $v['employee_position']?></th>
  </tr>



</table>
<?php } 
?>
