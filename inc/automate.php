<?php
/*
Will insert to the table ec_pm_login_tracker
*/
add_action('wp_login', 'ec_user_tracker',10,2);
$user = new WP_User();
$lg =$user->user_login;

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
            'read'=> 'NO'
        ) 
    );
    
    // echo $user->ID;
    
    // global $error;
    echo date("F j, Y");
    die();
}

?>