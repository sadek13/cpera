<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class ="mt-4">Project <?php echo $project_name ?> </h1>
           

                <nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
   
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item" >
          <a class="nav-link" aria-current="page" href="project-overview.php?id=<?php echo $id ?>">Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="project-gantt.php?id=<?php echo $id ?>">Gantt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">List</a>
        </li>
      
      </ul>
    </div>
  </div>
</nav>
    </main>
    </div>