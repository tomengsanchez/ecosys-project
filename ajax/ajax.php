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