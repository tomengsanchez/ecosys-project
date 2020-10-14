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
    <div container>
        <div class='row'>
            <div class='col'>
                <form action='' method='POST'>
                    <table class='table table-secondary'>
                        <tr>
                            <th colspan='3'><h4><center>Project Information</center></h4></th>
                        </tr>
                        <tr>
                            <th>Project Prefix</th><td><input type='text' name='proj_prefix' required value='<?php echo $project_info->project_prefix?>' disabled></td>
                        </tr>
                        <tr>
                            <th>Project Name</th><td><input type='text' name='proj_name' required value='<?php echo $project_info->project_name?>' size='50'></td>
                        </tr>
                        <tr>
                            <th>Project Description</th><td><textarea name='project_descrption' required   ><?php echo $project_info->project_description?></textarea></td>
                        </tr>
                        <tr>
                            <th></th><td><input type='submit' name='submit_edit' value='update' class='button button-primary'> </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class='col'>
                <?php
                
                
                //totalPaps Project
                
                
                
                //echo "<pre>" . print_r($userQuery) . "</pre>";
                // global $totalRegisteredQ;
                // $totalPaps = new WP_User_Query( $totalPapsQ );
                
                ;
                global $searchQ;
                $userQuery = new WP_User_Query( $searchQ );
                //echo $userQuery->request;

                
                $result = $userQuery->get_results();
                ?>
                
                <?php $queryNonce = wp_create_nonce(get_current_user_id(  ) . "ajax_query")?>
                <script type='text/javascript'>
                    var chartsSCM1= 0;
                    var chartsSES = 0;
                    var chartsSCM2 = 0;
                    jQuery(document).ready(function(){
                        var oldScm2DonePopulation;
                        

                        // setInterval(function(){
                        //     papsPopInterval();
                        // },10000);
                    });
                </script>    
                <table class='population-table table table-secondary table-hover table-responsive-sm'>
                    <tr>
                        <th colspan='3'><h4><center>Population Break Down</center></h4></th>
                    </tr>
                    
                    <tr>
                        <th>Total Imported</th><td><span id='totalPaps'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><th>Total Registered <i>(w/Last Name)</i></th><td ><span id='totalRegistered'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td>
                    </tr>
                    <tr>
                        <th><h5>Activity</h5></th><th><h5>Current</h5></th><th><h5>Done</h5></th>
                    </tr>
                    <tr>
                        <th>SCM 1</th><td><span id='scm1'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td><span id='scm1DONE' ><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td></td>
                    </tr>
                    
                    <tr>
                        <th>SES</th><td><span id='ses'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td><span id='sesDONE'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td></td>
                    </tr>
                    
                    <tr>
                        <th>SCM 2</th><td><span id='scm2'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td><span id='scm2DONE'><img src="<?php echo get_site_url() . "/wp-content/plugins/ecosys-project/img/ajax-loader-dark.gif"?>" width="20px" height="20px"></span></td><td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class='container'>
        <div class='row'>
            <div class='col'>
                <canvas id="totalPopulation" width="300" height="150" style='margin-left:-100px'></canvas>
                
            </div>
            <div class='col'>
                <canvas id="myChart" width="300" height="150" style='margin-left:-100px'></canvas>
            </div>
        </div>
       
        <script>
            
            $(document).ready(function(){
                //barchart
                var chartsSCM1 = 0;
                var ctx = document.getElementById('totalPopulation');
                var totPop = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total Control Number', 'Registered'],
                        datasets: [{
                            label: '# of Paps',
                            //data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(52, 118, 240, 0.2)',
                                'rgba(200, 156, 52, 0.2)'
                            ],
                            borderColor: [
                                'lightblue',
                                'lightgreen'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                //Pie CHart
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['SCM1 DONE', 'SES DONE', 'SCM2 DONE'],
                        datasets: [{
                            label: '# of Paps Done',
                            //data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                function papsPopInterval(){
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=paps_registered&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#totalRegistered').html(r);
                            totPop.data.datasets[0].data[1] = r;
                            totPop.update();
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=total_paps&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#totalPaps').html(r);
                            totPop.data.datasets[0].data[0] = r;
                            totPop.update();
                        }
                    });
                    
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=scm1&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#scm1').html(r);
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=scm1DONE&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#scm1DONE').html(r);
                            chartsSCM1 = r;
                            myChart.data.datasets[0].data[0] = r;
                            myChart.update();
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=ses&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#ses').html(r);
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=ses_done&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#sesDONE').html(r);
                            myChart.data.datasets[0].data[1] = r;
                            myChart.update();
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=scm2&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#scm2').html(r);
                            
                        }
                    });
                    $.ajax({
                        type:'POST',
                        data:{
                            "_nonce" : "<?php echo $queryNonce;?>"
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=scm2_done&project=<?php echo $_GET['project']?>',
                        success:function(r){
                            $('#scm2DONE').html(r);
                            myChart.data.datasets[0].data[2] = r;
                            myChart.update();
                        }
                    });
                    
                }
                
                papsPopInterval();
                setInterval(function(){
                    papsPopInterval();
                }, 10000);        
                
            });
            
        </script>
        
    </div>
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