<?php
function db_set(){
    global $wpdb;
    $tb = $wpdb->prefix . "ec_pm_projects";

    $query = 'CREATE TABLE '. $tb .' (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        project_prefix VARCHAR(30) NOT NULL,
        project_name longtext NOT NULL,
        project_description LONGTEXT NOT NULL
        )';
    
    $tb = $wpdb->prefix . "ec_pm_login_tracker";

    $queryTracker = 'CREATE TABLE '. $tb .' (
            id BIGINT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(30) NOT NULL,
            project VARCHAR(30) NOT NULL,
            full_name VARCHAR(50) NOT NULL,
            time varchar(30) NOT NULL,
            date varchar(30) NOT NULL,
            _read varchar(30) NOT NULL,
            )';
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    
    $tb = $wpdb->prefix . "ec_pm_activity_logger";
    $queryActivity = 'CREATE TABLE '. $tb .' (
        id BIGINT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id VARCHAR(30) NOT NULL,
        type VARCHAR(20) NOT NULL,
        _read VARCHAR(20) NOT NULL,
        project VARCHAR(20) NOT NULL
        )';
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");

    dbDelta($query);
    dbDelta($queryTracker);
    dbDelta($queryActivity);


}

 ?>
