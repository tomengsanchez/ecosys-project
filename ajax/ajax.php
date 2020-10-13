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

