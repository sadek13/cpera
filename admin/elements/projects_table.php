
<table id='projectsTable' class="table table-bordered table-hover">
      

  <?php foreach ($allProjects as $k=>$v){ ?>

    
      <thead>

<tr id=<?php echo $v['project_id'] ?> class='projTableRow'>

     

 <th><?php echo $v['project_name'] ?></th>
 <th>    
      
        <div class="progress-container">
        <span id='progressPercent' class='progressPercent percentage' align='center'></span>
        <div class="progress-bar progress" id="progress"></div>
    </div>

</th>
 <th><?php echo $v['status'] ?></th>
 
      

</tr>
        </thead>
   </a>

        <?php } ?>

</table>


