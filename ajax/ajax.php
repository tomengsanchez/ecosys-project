<?php 

//Begin Ajax Data Of Population Breakdown

add_action( 'wp_ajax_paps_registered', 'f_paps_registered' );
function f_paps_registered(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_total_paps_registered();
    die();
}

add_action( 'wp_ajax_total_paps', 'f_total_paps' );
function f_total_paps(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_total_paps();
        
    die();
}

add_action( 'wp_ajax_scm1', 'f_scm1' );
function f_scm1(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SCM-1');
    die();
}

add_action( 'wp_ajax_scm1DONE', 'f_scm1DONE' );
function f_scm1DONE(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SCM-1-DONE');
    die();
}


add_action( 'wp_ajax_ses', 'f_ses' );
function f_ses(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SES');
    die();
}

add_action( 'wp_ajax_ses_done', 'f_ses_done' );
function f_ses_done(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SES-DONE');
    die();
}

add_action( 'wp_ajax_scm2', 'f_scm2' );
function f_scm2(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SCM-2');
   
    die();
}

add_action( 'wp_ajax_scm2_done', 'f_scm2_done' );
function f_scm2_done(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    echo get_paps_count('SCM-2-DONE');
    die();
}


//END Ajax Data Of Population Breakdown

//Begin Ajax of User Entries

add_action( 'wp_ajax_get_entries_by_form', 'get_entries_by_form' );
function get_entries_by_form(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    global $wpdb;
    global $sqlCountTotalEntries;
    $result = $wpdb->get_results($sqlCountTotalEntries);
    $sqlCountTotalEntries;
    if($result){
      
        ?>
        <table class='table'>
            <tr>
                <th>Form Name</th>
                <th>Status</th>
                <th>Date</th>
                <th>Modified</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            foreach($result as $res){
            ?>
            <tr>
                <td><?php echo $res->post_title?></td>
                <?php
                if(!$res->status)
                    $status ='completed';
                else
                    $status = 'abandoned';
                
                ?>
                <td><?php echo ucfirst($status)?></td>
                <td><?php echo $res->date?></td>
                <td><?php echo $res->date_modified?></td>
                <td><a href='<?php echo get_admin_url()?>admin.php?page=wpforms-entries&view=details&entry_id=<?php echo $res->entry_id?>' target="_new">View</a></td>
                <?php if(current_user_can('manage_options'))
                {?>
                <td><a href='<?php echo get_admin_url()?>admin.php?page=wpforms-entries&view=edit&entry_id=<?php echo $res->entry_id?>' target="_new">Edit</a></td>
                <?php }
                ?>
            </tr>
            <?php
            }//foreach1 
            ?>
        </table>
        <?php
    }
    else{
    ?>
        <div class='alert alert-secondary' role='alert'>
            No Ses Entries For This Paps.<br>
            Maybe this paps had been interview through Onsite SES
        </div>
    <?php
    }
    ?>
    <?php
    die();
}

/**
 * function for Ajax Master Search
 */
add_action( 'wp_ajax_master_search', 'master_search_f' );
function master_search_f(){
    $searchQ = array( 
        'orderby'=>array('meta_key'=>'nickname'),
        'order'=>'ASC',
        'meta_query' => array(
                'relation' => 'OR',
                array(
                        'key'     => 'first_name',
                        'value'   => $_REQUEST['searchQ'],
                        'compare' => 'LIKE'
                ),
                array(
                        'key'     => 'last_name',
                        'value'   => $_REQUEST['searchQ'],
                        'compare' => 'LIKE'
                ),
                array(
                        'key'     => 'barangay',
                        'value'   => $_REQUEST['searchQ'],
                        'compare' => 'LIKE'
                ),
                array(
                        'key'     => 'nickname',
                        'value'   => $_REQUEST['searchQ'],
                        'compare' => 'LIKE'
                ),
                array(
                        'key'     => 'paps_status',
                        'value'   => $_REQUEST['searchQ'],
                        'compare' => 'LIKE'
                )

        )
    );
    
    $userQuery = new WP_User_Query( $searchQ );
    $result = $userQuery->get_results();
    //print_r($result);
    if(!$result){
        die("<h2 class='alert alert-secondary'>No Search Result For '" . $_REQUEST['searchQ'] . "'</h2>");
    }
    $queryNonce = wp_create_nonce(get_current_user_id(  ) . "ajax_query");
    ?>
    <script type='text/javascript'>
        $(document).ready(function(){
            
            
            $('.ses_button').click(function(){
                var title = "SES Entries for "  + $(this).attr('full_name');
                $('#ses_modal').modal('toggle');
                $('.modal-title').html(title);
                $('#ses_modal .modal-dialog .modal-content .modal-body').html('<div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div>');
                user_id= $(this).attr('user_id');
                $.ajax({
                    type:'POST',
                    data : {
                        "_nonce" : "<?php echo $queryNonce;?>",
                        uid:user_id
                    },
                    url : '<?php echo get_admin_url( )?>/admin-ajax.php?action=get_entries_by_form',
                    success:function(r){
                        
                        $('#ses_modal .modal-dialog .modal-content .modal-body').html(r);
                    }
                });
            });
        });
    </script>
    <hr>
    <div class='modal fade' id='ses_modal' role='dialog'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='modal-header'>
                    <h5 class="modal-title" id="exampleModalLongTitle">SES entries</h5>
                </div>
                <div class='modal-body'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        
    </div>
    <table id='project-table' class='table'>
        
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
                <th>Ses Entries</th>
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
                        <td><a class='link' style='cursor:pointer'  onclick='window.open("<?php echo get_site_url() . "/user-profile/?user_id=" . $res->ID?>","_blank","toolbar=yes,scrollbars=yes,resizable=yes")'><?php echo $res->user_login?></a></td>
                        <td><?php echo get_user_meta( $res->ID,'last_name',true)?></td>
                        <td><?php echo $res->first_name?></td>
                        <td><?php echo get_user_meta( $res->ID,'paps_status',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'mobile_number',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'barangay',true)?></td>
                        <td><?php echo get_user_meta( $res->ID,'city',true)?></td>
                        <td>(<?php echo getUserActivity($res->ID);?>)<?php echo get_user_meta( $res->ID,'last-login',true)?></td>
                        <td><span class='button ses_button' user_id='<?php echo $res->ID; ?>' full_name='<?php echo $res->user_login?>-<?php echo $res->first_name?><?php echo $res->last_name?>'><?php echo get_total_ses_entries($res->ID); ?></span></td>
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
    die();
}
add_action( 'wp_ajax_get_activity_log', 'get_activity_log' );
function get_activity_log(){
    //print_r($_REQUEST);
    $result = getUserActivityList($_REQUEST['uid']);
    //print_r($result);
   if($result){
    ?>
    <table class='table'>
        <tr>
            <th>Date</th>
            <th>Action</th>
            <th>Object</th>
        </tr>
        <?php
            foreach($result as $res){
                ?>
                <tr>
                    <td><?php echo $res->modified_date; ?></td>
                    <td><?php echo $res->action; ?></td>
                    <td><?php echo $res->object_type; ?></td>
                </tr>
                <?php
            } 
        ?>
    </table>
    <?php
   }
   else{
    ?>
    <div class='alert alert-secondary' role='alert'>
        No Activity For This Paps.<br>
        
    </div>
<?php 
   }
    die();
}