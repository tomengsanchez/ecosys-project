<?php

//get All Paps
function get_total_paps(){
    global $wpdb;
    $cnt = $wpdb->get_var( "SELECT count(*) as cnt FROM " . $wpdb->prefix . "users INNER JOIN " . $wpdb->prefix . "usermeta ON ( " . $wpdb->prefix . "users.ID = " . $wpdb->prefix . "usermeta.user_id ) WHERE 1=1 AND ( ( " . $wpdb->prefix . "usermeta.meta_key = 'project' AND " . $wpdb->prefix . "usermeta.meta_value = '" . $_GET['project'] . "' ) ) ORDER BY user_login ASC" );
    return $cnt;
}

//get All Registered
function get_total_paps_registered(){
    global $totalRegisteredQ;
    global $wpdb;
    $sql = "SELECT count(*) 
                FROM " . $wpdb->prefix . "users 
                INNER JOIN " . $wpdb->prefix . "usermeta 
                    ON ( " . $wpdb->prefix . "users.ID = " . $wpdb->prefix . "usermeta.user_id ) 
                INNER JOIN " . $wpdb->prefix . "usermeta AS mt1 
                    ON ( " . $wpdb->prefix . "users.ID = mt1.user_id ) WHERE 1=1 
                    AND (
                            ( " . $wpdb->prefix . "usermeta.meta_key = 'project' AND " . $wpdb->prefix . "usermeta.meta_value = '" . $_GET['project'] . "' ) 
                            AND ( mt1.meta_key = 'last_name' AND mt1.meta_value != '' ) 
                        ) 
            ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    return $cnt;
}
$status = "";
//get Paps Count By Status
function get_paps_count($status){
    global $wpdb;
    $sql = "SELECT count(*)
                FROM " . $wpdb->prefix . "users 
                INNER JOIN " . $wpdb->prefix . "usermeta 
                    ON ( " . $wpdb->prefix . "users.ID = " . $wpdb->prefix . "usermeta.user_id ) 
                INNER JOIN " . $wpdb->prefix . "usermeta AS mt1 
                    ON ( " . $wpdb->prefix . "users.ID = mt1.user_id ) 
                INNER JOIN " . $wpdb->prefix . "usermeta AS mt2 
                    ON ( " . $wpdb->prefix . "users.ID = mt2.user_id ) WHERE 1=1 
                    AND (
                            ( " . $wpdb->prefix . "usermeta.meta_key = 'project' AND " . $wpdb->prefix . "usermeta.meta_value = '" . $_GET['project'] . "' ) 
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = '" . $status . "' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    return $cnt;
    
}

/**
 * GEt the project Activity
 * 
 * @param $project project prefix  
 */
function get_project_activity($project){
    global $wpdb;
    $sql = "SELECT count(*) from " . $wpdb->prefix. "ec_pm_activity_logger where project='" . $project. "'";
    $cnt = $wpdb->get_var($sql);
    return $cnt;
}
?>