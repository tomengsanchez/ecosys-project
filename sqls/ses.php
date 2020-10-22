<?php 
global $sqlGetUserEntriedForms;
$sqlGetUserEntriedForms = "
    select user_id,post_title,ID
        from 
        wp_wpforms_entries as entries,
        wp_posts as post 
        where 
            user_id='" . $_REQUEST['uid'] . "' and entries.form_id = post.ID GROUP BY ID
";
global $sqlGetUserEntries;
$sqlGetUserEntries = "
select user_id,post_title,ID
    from 
    wp_wpforms_entries as entries,
    wp_posts as post 
    where 
        user_id='" . $_REQUEST['user_id'] . "' and entries.form_id = post.ID AND post.ID = " . $_GET['post_id'] . "
";
global $sqlCountTotalEntries;
$sqlCountTotalEntries = "
select *
    from 
    wp_wpforms_entries as entries,
    wp_posts as post 
    where 
        user_id='" . $_REQUEST['uid'] . "' and entries.form_id = post.ID
";
?>