<?php
function db_set(){
    global $wpdb;
    $tb = $wpdb->prefix . "ec_pm_projects";

    $query = 'CREATE TABLE '. $tb .' (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        project_prefix VARCHAR(30) NOT NULL,
        project_name VARCHAR(30) NOT NULL,
        project_description VARCHAR(120) NOT NULL,
        project_scm1 TEXT(500) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($query);


    $wpdb->insert( 
        $tb, 
        array( 
            'project_prefix' => 'SAMPLE', 
            'project_name' => 'This is an Example Project', 
            'project_description' => 'This is the description', 
            'project_scm1' => 'This is the description', 
        ) 
    );
}

 ?>
