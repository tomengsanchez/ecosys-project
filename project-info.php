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
        $search_term = $_GET['s'];
        if(!$_GET['numbers'])
            $numbers = 50;
        else
            $numbers = $_GET['numbers'];
        $searchQ = array( 
                        'number' => '' . $numbers. '',
                        'meta_key' => 'project', 
                        'meta_value' => '' .$_GET['project'] . '',
                        'orderby'=>array('meta_key'=>'nickname'),
                        'order'=>'ASC',
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'key'     => 'first_name',
                                'value'   => $search_term,
                                'compare' => 'LIKE'
                            ),
                            array(
                                'key'     => 'last_name',
                                'value'   => $search_term,
                                'compare' => 'LIKE'
                            ),
                            array(
                                'key'     => 'barangay',
                                'value'   => $search_term ,
                                'compare' => 'LIKE'
                            ),
                            array(
                                'key'     => 'nickname',
                                'value'   => $search_term ,
                                'compare' => 'LIKE'
                            ),
                            array(
                                'key'     => 'paps_status',
                                'value'   => $search_term ,
                                'compare' => 'LIKE'
                            )
                            
                        )
                    );
        $userQuery = new WP_User_Query($searchQ);
        $result = $userQuery->get_results();
        $userQuery->total_users;
        
        //totalPaps Project
        $totalPaps = new WP_User_Query(array('meta_key' => 'project', 'meta_value' => '' .$_GET['project'] . ''));
        //echo "<pre>" . print_r($userQuery) . "</pre>";
    ?>
    <div>
    
    </div>
    <div>                                            
        <table>
            <tr>
                <td></td><td><pre id='sampleDiv'></pre></td>
            </tr>
            <tr>
                <th><h2>Population</h2></th>
            </tr>
            <tr>
                <th><h4>Paps Total</h4></th><td><?php echo $totalPaps->total_users; ?></td>
            </tr>
        </table>
    </div>
    <div>
    </div>
    <hr>
    <!-- <form  action='<?php echo get_site_url()?>/wp-admin/admin.php?page=project-info&project=NSCR' method='GET'>
        <table>
            <tr>
                
            </tr>
            <tr>
                <td>
                    <h4>Showing 
                    <select name='numbers'>
                        <option value='50' <?php if($numbers == 50) echo "selected" ?> >50</option>
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
    </form>                     -->
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
                        <td><a style='cursor:pointer'  onclick='window.open("<?php echo get_site_url() . "/user-profile/?user_id=" . $res->ID?>","_blank","toolbar=yes,scrollbars=yes,resizable=yes")'><?php echo $res->user_login?></a></td>
                        <td><?php echo get_user_meta( $res->ID,'last_name',true)?></td>
                        <td><?php echo $res->first_name?></td>
                        <td><?php echo get_user_meta( $res->ID,'paps_status',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'mobile_number',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'barangay',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'city',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'last-login',true)?></td>
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