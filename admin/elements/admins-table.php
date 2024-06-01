


<table id='adminsTable' class="table table-bordered table-hover">
      

  

      <thead>


        </thead>
<tbody>
<?php 

foreach($allAdmins as $sub){ ?>

<tr id="<?php echo $sub['admin_id']?>">

<td><?php echo $sub['admin_fn'],$sub['admin_ln']?></td>


</tr>

<?php } ?>


</tbody>

</table>




