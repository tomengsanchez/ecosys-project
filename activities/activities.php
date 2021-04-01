<?php



?>
<i>This module will add activities on this project</i>
<div class='container-fluid border'>
    <div class='row'>   
        <div class="col-2">
            <ul class="nav flex-column">
                <li class="nav-item"><a class='nav-link 'href='<?php echo get_site_url()?>/wp-admin/admin.php?page=project-info&project=<?php echo $_GET['project'] ?>&tab=activities'>Dashboard</a></li>
                <li class="nav-item"><a class='nav-link active' href='<?php echo get_site_url()?>/wp-admin/admin.php?page=project-info&project=<?php echo $_GET['project'] ?>&tab=activities&sub=list'>Activity List</a></li>
            </ul> 
        </div>
        <div class="col-8 border border-red">
            <?php 
                if(!$_GET['sub']){
                    echo "Dashboard";
                }
                else {
                    include_once('list.php') ;
                }
            ?>
        </div>
    </div>
</div>
<?php

?>