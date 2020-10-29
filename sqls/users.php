<?php
global $totalRegisteredQ;

$totalRegisteredQ = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
        
    ));


global $sqlSCM1Q;  
$sqlSCM1Q = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SCM-1',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    ));
global $sqlSCM1DONEQ; 
$sqlSCM1DONEQ  = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SCM-1-DONE',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    ));
global $sqlSESQ;
$sqlSESQ  = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SES',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    ));
global $sqlSESDONEQ;
$sqlSESDONEQ  = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SES-DONE',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    ));
global $sqlSCM2Q;
$sqlSCM2Q  = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SCM-2',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    ));
global $sqlSCM2DONEQ;

$sqlSCM2DONEQ  = array(
    'meta_query'=>array(
        'relation'=>'AND',
        array(
            'key'=>'project',
            'value'=>'' .$_GET['project'] . '',
            'compare'=>'='
        ),
        array(
            'key'=>'paps_status',
            'value'=>'SCM-2-DONE',
            'compare'=>'='
        ),
        array(
            'key'=>'last_name',
            'value'=>'',
            'compare'=>'!='
        )
        
    )); 
global $totalPapsQ;
$totalPapsQ = array('meta_key' => 'project', 'meta_value' => '' .$_GET['project'] . '');

global $searchQ;
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
    //$userQuery = new WP_User_Query($searchQ);
    
global $userActivity;



function getUserActivity($userId){
    global $wpdb;
    $tb = $wpdb->prefix . "ualp_user_activity";
    $sqlGetUserActivity = "SELECT count(*) as logs FROM " . $tb . " WHERE user_id = '" . $userId . "'";
    $sqlGetUserActivity= $wpdb->get_row($sqlGetUserActivity,OBJECT);
    return $sqlGetUserActivity->logs;
}
//add_action('init','getUserActivity');
function getUserActivityList($userId){
    global $wpdb;
    $tb = $wpdb->prefix . "ualp_user_activity";
    $sqlGetUserActivity = "SELECT * FROM " . $tb . " WHERE user_id = '" . $userId . "'";
    $sqlGetUserActivity= $wpdb->get_results($sqlGetUserActivity,OBJECT);
    
    return $sqlGetUserActivity;
}
function getUserTaggedActivityList($userId){
    global $wpdb;
    $tb = $wpdb->prefix . "ualp_user_activity";
    $userId = get_user_meta( $userId, 'nickname',true);
    $sqlGetUserActivity = "SELECT * FROM " . $tb . " WHERE post_title = '" . $userId . "'";
    $sqlGetTaggedUserActivity= $wpdb->get_results($sqlGetUserActivity,OBJECT);
    
    return $sqlGetTaggedUserActivity;
}
function getUserTaggedActivity($userId){
    global $wpdb;
    $tb = $wpdb->prefix . "ualp_user_activity";
    $userId = get_user_meta( $userId, 'nickname',true);
    $sqlGetUserActivity = "SELECT count(*) as cnt FROM " . $tb . " WHERE post_title = '" . $userId . "'";
    $sqlGetTaggedUserActivity= $wpdb->get_row($sqlGetUserActivity,OBJECT);
    
    return $sqlGetTaggedUserActivity->cnt;
}

?>