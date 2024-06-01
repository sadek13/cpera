
<table id='catTable' class="table table-bordered table-hover">
      

  

      <thead>
    <tr>

     
 <th>Name</th>
 <th>Actions</th>
      
  
</tr>

        </thead>
<tbody>
<?php 

foreach($allCat as $sub){ ?>

<tr>

<td><?php echo $sub['category_name']?></td>
<td style="text-align: right;"><span  id="<?php echo $sub['category_ID']?>" class="fa fa-ban delete "></span>
<span  id="<?php echo $sub['category_ID']?>" class="fa fa-edit edit" name="<?php echo $sub['category_name']?>">
</span>
</td>


<?php } ?>
</tr>

</tbody>

</table>


