<?php


function project_info(){
    global $wpdb;
    $tb = $wpdb->prefix . "ec_pm_projects";
    

    print_r($project_info);

    

    if($_POST['submit_edit']){
        
        $wpdb->update( 
            $tb, 
            array( 
                'project_name' => $_POST['proj_name'],   // string
                'project_description' => $_POST['project_descrption']    // integer (number) 
            ), 
            array( 'project_prefix' => $_GET['project'] )
          
        );
        //echo "<script type='text/javascript'>reload()</script>";
        ?><div class='notice notice-success is-dismissible'>Updated</div><?php
    }

    $q = 'select * from '. $tb .' WHERE project_prefix = "'. $_GET['project'] .'"';
    $project_info = $wpdb->get_row($q);

    ?>
    <hr>
    <a class='button button-secondary' href='<?php echo get_site_url()?>/wp-admin/admin.php?page=ecosys-project-page'>Back to Project Management</a>
    <hr>
    <form action='' method='POST'>
                <table>
                    <tr>
                        <td>Project Prefix</td><td><input type='text' name='proj_prefix' required value='<?php echo $project_info->project_prefix?>' disabled></td>
                    </tr>
                    <tr>
                        <td>Project Name</td><td><input type='text' name='proj_name' required value='<?php echo $project_info->project_name?>' size='50'></td>
                    </tr>
                    <tr>
                        <td>Project Description</td><td><textarea name='project_descrption' required   ><?php echo $project_info->project_description?></textarea></td>
                    </tr>
                    <tr>
                        <td></td><td><input type='submit' name='submit_edit' value='update' class='button button-primary'> </td>
                    </tr>
                <table>
            </form>
     <hr>
    <?php
    
    //print_r($_POST);
}
?>