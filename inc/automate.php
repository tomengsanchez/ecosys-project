<?php
/**
 * this file is for the hooks with automation... and other hooks for other plugin
 */


$user = new WP_User();
$lg =$user->user_login;

/**
 * Will insert to the project activity ogger
 */
add_action('wp_login', 'project_activity_logger',10,2);
function project_activity_logger($lg,$user){
    
    global $wpdb;
    $tb = $wpdb->prefix . "ec_pm_activity_logger";
    $wpdb->insert( 
        $tb, 
        array( 
            'ID'=>$wpdb->insert_id,
            'user_id'=> $user->ID,
            'type'=>'LOGIN',
            '_read'=>'NO',
            'project'=>get_user_meta( $user->ID,'project',true)
        ) 
    );
    
    $project = get_user_meta( get_current_user_id(),'project',true);
    if($project){
        wp_redirect(get_home_url() . '/respondent-dashboard');
    }
    

}


/*
Will insert to the table ec_pm_login_tracker
*/
add_action('wp_login', 'ec_user_tracker',10,2);
function ec_user_tracker($lg,$user) {
    // your code
    global $wpdb;
    $tb = $wpdb->prefix . "ec_pm_login_tracker";
    $wpdb->insert( 
        $tb, 
        array( 
            'ID'=>$wpdb->insert_id,
            'user_id'=> $user->ID,
            'project'=> get_user_meta( $user->ID,'project',true),
            'full_name' => get_user_meta( $user->ID,'last_name',true) . " " . get_user_meta( $user->ID,'first_name',true), 
            'time' => current_time('g:i a',true),
            'date' => date( 'F j, Y' ) ,
            '_read'=> 'NO'
        ) 
    );
    
    // echo $user->ID;
    
    // global $error;
    echo date("F j, Y");
    
}



?>