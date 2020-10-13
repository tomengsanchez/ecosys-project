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
    
    $tb = $wpdb->prefix . "ec_pm_projects";

    $queryTracker = 'CREATE TABLE '. $tb .' (
            id INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) NOT NULL,
            project VARCHAR(30) NOT NULL,
            full_name VARCHAR(50) NOT NULL,
            time varchar(30) NOT NULL,
            date varchar(30) NOT NULL,
            _read varchar(30) NOT NULL,
            )';
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    dbDelta($query);
    dbDelta($queryTracker);

}

 ?>
