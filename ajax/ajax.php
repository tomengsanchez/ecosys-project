<?php 
add_action('wp_ajax_sample1','sample_ajax1');

function sample_ajax1(){
    
}

add_action('wp_ajax_datatable_ajax','sample_datatable_ajax');

function sample_datatable_ajax(){
    if (!wp_verify_nonce( $_REQUEST['nonce'],'projectTableQuery')) {
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
        echo "\"" . $res->user_login . "\",
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