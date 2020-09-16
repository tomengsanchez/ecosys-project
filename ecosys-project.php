<?php 
/**
 * Plugin Name: Ecosys Project Management
 * Description:       Add Ecosys Projects
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tomeng Sanchez Napaka POGI
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       Ecosys Project Management for Ecosys Systems Only
 * Domain Path:       /languages
 * 
 * */

//DB installation

include_once('installation/ecosys_db_setup.php');
include_once('project-info.php');
// Register hook
register_activation_hook(__FILE__,'db_set');

function css_cdn(){
    ?>
   
    <?php
}
add_action('admin_head','css_cdn');
add_action('admin_enqueue_scripts', 'my_enqueue');

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    ?>

    <?php
    wp_enqueue_style('dt-css', plugin_dir_url(__FILE__) . 'Datatable/datatables.css');
    wp_enqueue_script('dt-jquery-ecosys', plugin_dir_url(__FILE__) . 'jqjs/jquery.min.js');
    wp_enqueue_script('dt-datatable', plugin_dir_url(__FILE__) . 'Datatable/datatables.js');

    wp_enqueue_script('ecosysjs', plugin_dir_url(__FILE__) . 'js/ecosys.js','','',true);
}


function ecosys_project_add_menu(){
    add_menu_page('Ecosys Project Management','Ecosys Project Manager','manage_options','ecosys-project-page','ecosys_main_function','dashicons-welcome-widgets-menus','200');
}
add_action('admin_menu','ecosys_project_add_menu');

//submenu for projects
function ecosys_project_add_sub_menu(){
    add_submenu_page( 'ecosys-project-page1','Project Information', 'Poject', 'manage_options', 'project-info','project_info', 1);
}
add_action('admin_menu','ecosys_project_add_sub_menu');


function ecosys_main_function(){
    if(array_key_exists('submit_company_name',$_POST)){
        update_option('company_name1',$_POST['company_name1']);
        ?>
        <div>Company Name Updated</div>
        <?php
    }
    $company_name = get_option('company_name1','Not Set');
    ?>

        <h1>Welcome to Ecosys Projects Manager</h1>
        <form class='wrap' action='' method='POST'>
        <h2>Company Name : <input type='text' name='company_name1' value='<?php print $company_name;?>'></h2>
        <input type="submit" name='submit_company_name' class='button button-primary' value='Update Company Name'>
        </form>
    <hr>
    <h3>Add New Project</h3>
    <form action='' method='POST'>
        <table>
            <tr>
                <td>Project Prefix</td><td><input type='text' name='proj_prefix' required></td>
            </tr>
            <tr>
                <td>Project Name</td><td><input type='text' name='proj_name' required></td>
            </tr>
            <tr>
                <td>Project Description</td><td><textarea name='project_descrption' required></textarea></td>
            </tr>
            <tr>
                <td></td><td><input type='submit' name='submit_project' value='Add New Project' class='button button-primary'> </td>
            </tr>
        <table>
    </form>
    <?php 
    if($_POST['submit_project']){
        print_r($_POST);
        global $wpdb;
        $tb = $wpdb->prefix . "ec_pm_projects";
        $wpdb->insert( 
            $tb, 
            array( 
                'project_prefix' => $_POST['proj_prefix'], 
                'project_name' => $_POST['proj_name'], 
                'project_description' => $_POST['project_descrption'], 
            ) 
        );
        Echo "Successfully Added New Project";
    }
    ?>
    <hr>
    <h3>Here are your Projects</h3>

    <hr>
    <table id="example" class="display wp-list-table widefat fixed striped table-view-list" width="100%">
    <thead>
        <tr>
        <th>Project Prefix</th>
        <th>Porject Name</th>
        <th>Project Description</th>
        <Td>Actions</td>
        </tr>
    </thead>
    <tbody>
        <?php 
            global $wpdb;
            $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ec_pm_projects", OBJECT );
            foreach ($results as $res){
                echo "<tr>";
                echo "<td>" . $res->project_prefix. "</td>";
                echo "<td>" . $res->project_name. "</td>";
                echo "<td>" . $res->project_description. "</td>";
                echo "<td><a href='" . get_site_url() . "/wp-admin/admin.php?page=project-info&project=" . $res->project_prefix . "'> Info</a></td>";
                echo "</tr>";
            }

        ?>
    </tbody>
    <tfoot>
        <tr>
        <tr>
        <th>Project Prefix</th>
        <th>Porject Name</th>
        <th>Project Description</th>
        <Td></td>
        </tr>
        </tr>
    </tfoot>
 
    <tbody>
    </tbody>
</table>
    <?php
}

?>
