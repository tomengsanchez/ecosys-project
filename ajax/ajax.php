<?php 
add_action('wp_ajax_sample1','sample_ajax1');

function sample_ajax1(){
    
}

add_action('wp_ajax_datatable_ajax','sample_datatable_ajax');

function sample_datatable_ajax(){
    if (!wp_verify_nonce( $_REQUEST['nonce'],get_current_user_id() . "-projectTableQuery")) {
        exit("SECURITY ERROR");
        //die();
    }   

    
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
    
    echo '{
        "draw" : "1",
        "recordsTotal": "' . $userQuery->total_users . '",
        "data":[';
        $x =1;
    foreach($result as $res){
        echo "[";
        
        echo "\"<a style='cursor:pointer' onclick='window.open(&quot;" . get_site_url() . "/user-profile/?user_id=" . $res->ID . "&quot;,&quot;_blank&quot;,&quot;toolbar=yes,scrollbars=yes,resizable=yes&quot;)'>" . $res->user_login . "</a>\",
        ";
        echo "\"" . $res->last_name . "\",
        ";
        echo "\"" . $res->first_name . "\",
        ";
        echo "\"" . $res->paps_status . "\",
        ";
        echo "\"" . $res->mobile_number . "\",
        ";
        echo "\"" . $res->barangay . "\",
        ";
        echo "\"" . $res->city . "\",
        ";
        echo "\"" . $res->last_login . "\",
        ";
        echo "\"" . $res->last_login_ip . "\",
        ";
        echo "\"" . $res->default_password . "\",
        ";
        echo "\"" . get_user_meta( $res->ID,'SCM1-Q-4',true). "\",
        ";
        echo "\"" . get_user_meta( $res->ID,'SCM2-Q-4',true) . "\"
        ";
        echo "]";
        if($x != $userQuery->total_users){
            echo ",
            ";
            $x++;
        }
        
        
    }
    echo "
    ]
}";
    die();
    
}
add_action( 'wp_ajax_paps_registered', 'f_paps_registered' );

function f_paps_registered(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
    echo $cnt;
    die();
}

add_action( 'wp_ajax_total_paps', 'f_total_paps' );

function f_total_paps1(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    global $totalPapsQ;
    $totalPaps = new WP_User_Query( $totalPapsQ );
    echo $totalPaps->total_users;
    die();
}

function f_total_paps(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
    global $wpdb;
    $cnt = $wpdb->get_var( "SELECT count(*) as cnt FROM " . $wpdb->prefix . "users INNER JOIN " . $wpdb->prefix . "usermeta ON ( " . $wpdb->prefix . "users.ID = " . $wpdb->prefix . "usermeta.user_id ) WHERE 1=1 AND ( ( " . $wpdb->prefix . "usermeta.meta_key = 'project' AND " . $wpdb->prefix . "usermeta.meta_value = '" . $_GET['project'] . "' ) ) ORDER BY user_login ASC" );
    echo $cnt;
    
    die();
}

add_action( 'wp_ajax_scm1', 'f_scm1' );

function f_scm1(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SCM-1' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
    die();
}
add_action( 'wp_ajax_scm1DONE', 'f_scm1DONE' );

function f_scm1DONE(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SCM-1-DONE' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
    die();
}


add_action( 'wp_ajax_ses', 'f_ses' );

function f_ses(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SES' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
    echo $sqlSES->total_users;
    die();
}
add_action( 'wp_ajax_ses_done', 'f_ses_done' );

function f_ses_done(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SES-DONE' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
    die();
}
add_action( 'wp_ajax_scm2', 'f_scm2' );

function f_scm2(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SCM-2' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
   
    die();
}
add_action( 'wp_ajax_scm2_done', 'f_scm2_done' );

function f_scm2_done(){
    if (!wp_verify_nonce( $_REQUEST['_nonce'],get_current_user_id() . "ajax_query")) {
        exit("SECURITY ERROR");
        //die();
    }  
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
                            AND ( mt1.meta_key = 'paps_status' AND mt1.meta_value = 'SCM-2-DONE' ) 
                            AND ( mt2.meta_key = 'last_name' AND mt2.meta_value != '' ) 
                        ) 
                ORDER BY user_login ASC";
    //$totalRegistered = new WP_User_Query( $totalRegisteredQ );
    $cnt = $wpdb->get_var($sql);
    echo $cnt;
    die();
}
