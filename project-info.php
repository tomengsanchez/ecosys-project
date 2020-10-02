<?php

add_shortcode('ec_project','project_info');
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
        </table>
    </form>
    <hr>
    
     
    <?php
	$result = $wpdb->get_results($showcountQuery);
	
	//totalPaps Project
    
    
    
    //echo "<pre>" . print_r($userQuery) . "</pre>";
    global $totalRegisteredQ;
    $totalRegistered = new WP_User_Query( $totalRegisteredQ );
    global $totalPapsQ;
    $totalPaps = new WP_User_Query( $totalPapsQ );
    
    global $sqlSCM1Q;
    $sqlSCM1 = new WP_User_Query( $sqlSCM1Q);
    global $sqlSCM1DONEQ;
    $sqlSCM1DONE = new WP_User_Query( $sqlSCM1DONEQ);
    global $sqlSESQ;
    $sqlSES = new WP_User_Query( $sqlSESQ);
    global $sqlSESDONEQ;
    $sqlSESDONE = new WP_User_Query( $sqlSESDONEQ );
    global $sqlSCM2Q;
    $sqlSCM2 = new WP_User_Query( $sqlSCM2Q);
    global $sqlSCM2DONEQ;
    $sqlSCM2DONE = new WP_User_Query( $sqlSCM2DONEQ );
    global $searchQ;
    $userQuery = new WP_User_Query( $searchQ );
    $result = $userQuery->get_results();
    ?>
        
        <table class='population-table table table-dark table-hover table-responsive-sm'>
            <tr>
                <th colspan='4'><h4><center>Population Break Down</center></h4></th>
            </tr>
            
            <tr>
                <th>Total Imported</th><td><?php echo $totalPaps->total_users; ?></td><th>Total Registered <i>(w/Last Name)</i></th><td><?php echo $totalRegistered->total_users; ?></td>
            </tr>
            <tr>
                <th><h5>Activity</h5></th><th><h5>Current</h5></th><th><h5>Done</h5></th>
            </tr>
            <tr>
                <th>SCM 1</th><td><?php echo $sqlSCM1->total_users; ?></td><td><?php echo $sqlSCM1DONE->total_users; ?></td>
            </tr>
            
            <tr>
                <th>SES</th><td><?php echo $sqlSES->total_users; ?></td><td><?php echo $sqlSESDONE->total_users; ?></td>
            </tr>
            
            <tr>
                <th>SCM 2</th><td><?php echo $sqlSCM2->total_users; ?></td><td><?php echo $sqlSCM2DONE->total_users; ?></td>
            </tr>
            
            
        </table>
    <hr>
    
    
    <form  action='<?php echo get_site_url()?>/wp-admin/admin.php?page=project-info&project=NSCR' method='GET'>
        <table>
            <tr>
                
            </tr>
            <tr>
                <td>
                    <h4>Showing 
                    <select name='numbers'>
                        <option value='50' <?php if($numbers == 50){ echo "selected";} ?> >50</option>
                        <option value='100' <?php if($numbers == 100) echo "selected" ?> >100</option>
                        <option value='200'<?php if($numbers == 200) echo "selected" ?> >200</option>
                        <option value='500' <?php if($numbers == 500) echo "selected" ?> >500</option>
                        <option value='1000' <?php if($numbers == 1000) echo "selected" ?>>1000</option>
                        <option value='2000' <?php if($numbers == 2000) echo "selected" ?> >2000</option>
                        <option value='5000' <?php if($numbers == 5000) echo "selected" ?>>5000</option>
                    </select>
                     of <?php echo $userQuery->total_users; ?><h4>
                </td>
                <td><input type='hidden' name='page' value='project-info'><input type='hidden' name='project' value='<?php echo $_GET['project'] ?>'><h4>Search Keyword</h4>
                </td><td><input type='text' name='s' value='<?php echo $search_term ?>'></td>
                <td><input type='submit' name='submit_search' value='Search/Update Table'></td>
                <td><h4>Search Results</h4></td><td><?php echo $userQuery->total_users; ?></td>
            </tr>
        </table>
    </form>                    
    
    <script type='text/javascript'>
     
    </script>        
    
    <table id='project-table' class='display'>
       
        <thead>
            <tr>
                <th>Control Number</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Status</th>
                <th>Mobile Number</th>
                <th>Barangay</th>
                <th>City</th>
                <th>Last Login</th>
                <th>Last Login Ip</th>
                <th>Default Password</th>
                <th>SCM1 Question</th>
                <th>SCM2 Question</th>
                
            </tr>
        </thead>
        
           
        
        <tbody>
            <?php
                foreach($result as $res){
                    ?>
                    <tr>
                        <td><a clas='link' style='cursor:pointer'  onclick='window.open("<?php echo get_site_url() . "/user-profile/?user_id=" . $res->ID?>","_blank","toolbar=yes,scrollbars=yes,resizable=yes")'><?php echo $res->user_login?></a></td>
                        <td><?php echo get_user_meta( $res->ID,'last_name',true)?></td>
                        <td><?php echo $res->first_name?></td>
                        <td><?php echo get_user_meta( $res->ID,'paps_status',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'mobile_number',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'barangay',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'city',true)?></td>
                        <td>(<?php echo getUserActivity($res->ID);?>)<?php echo get_user_meta( $res->ID,'last-login',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'last-login-ip',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'default_password',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'SCM1-Q-4',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'SCM2-Q-4',true)?></td>
                    </tr>
                    <?php        
                }
             ?>
        </tbody>
    </table>
    
    <?php
    
    //print_r($_POST);
}
?>