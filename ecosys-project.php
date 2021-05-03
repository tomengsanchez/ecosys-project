<?php 
/**
 * Plugin Name: Ecosys Project Management made by Tomeng Sanchez
 * Description:       Add Ecosys Projects
 * Version:           1.0.1
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
include_once('inc/functions.php');
include_once('inc/automate.php');
include_once('ajax/ajax.php');
include_once('sqls/users.php');
include_once('sqls/ses.php');
include_once('project-info.php');
include_once('inc/automate.php');
// Register hook
register_activation_hook(__FILE__,'db_set');

/*
*Main Function
*/

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    ?>

    <?php
    wp_enqueue_style('bs-css', plugin_dir_url(__FILE__) . 'bootstrap-4.3.1/css/bootstrap.css');
    wp_enqueue_style('dt-css', plugin_dir_url(__FILE__) . 'Datatable/datatables.css');
    //wp_enqueue_style('eco-charts-css', plugin_dir_url(__FILE__) . 'charts/chart.min.css');
    wp_enqueue_style('ecosyscss', plugin_dir_url(__FILE__) . 'css/ecosys.css');

    //wp_enqueue_script('dt-jquery-ecosys', plugin_dir_url(__FILE__) . 'jqjs/jquery.min.js');
    wp_enqueue_script('dt-datatable-eco', plugin_dir_url(__FILE__) . 'Datatable/datatables.min.js','','');
    wp_enqueue_script('bs-js', plugin_dir_url(__FILE__) . 'bootstrap-4.3.1/js/bootstrap.js','','');
    //wp_enqueue_script('eco-charts-js', plugin_dir_url(__FILE__) . 'charts/chart.min.js');
    wp_enqueue_script('ecosysjs', plugin_dir_url(__FILE__) . 'js/ecosys.js','','',true);
}

function cdns(){
    ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
    <?php
}
if($_GET['page']=='project-info'){
    add_action('admin_enqueue_scripts', 'my_enqueue');
    add_action('admin_head','cdns');
}


function ecosys_project_add_menu(){
    add_menu_page('Ecosys Project Management','Ecosys Project Manager','manage_ecosys_project','ecosys-project-page','ecosys_main_function','dashicons-welcome-widgets-menus','200');
}
add_action('admin_menu','ecosys_project_add_menu');

//submenu for projects
function ecosys_project_add_sub_menu(){
    add_submenu_page( 'ecosys-project-page1','Project Information', 'Poject', 'manage_ecosys_project', 'project-info','project_info', 1);
}
add_action('admin_menu','ecosys_project_add_sub_menu');

/*
*Main Function
*/
function wporg_simple_role_caps() {
    // Gets the simple_role role object.
    $role = get_role( 'administrator' );
 
    // Add a new capability.
    $role->add_cap( 'manage_ecosys_project', true );
}
add_action( 'init', 'wporg_simple_role_caps', 11 );
function add_role_eco(){
    add_role(
        'ecosys_admin1',
        'Ecosys Admin1',
        [
            'manage_ecosys_project'         => true,
            'read_post' =>true,
            'edit_posts'   => true,
            'upload_files' => true,
            'list_users'=>true,
            'edit_users'=>true,
        ]
    );
}
add_action( 'init', 'add_role_eco', 11 );
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
                echo "<td>" . $res->project_prefix. "(" . get_project_activity($res->project_prefix). ")</td>";
                echo "<td>" . $res->project_name. "</td>";
                echo "<td>" . $res->project_description. "</td>";
                echo "<td>";
                    echo"<a  href='" . get_site_url() . "/wp-admin/admin.php?page=project-info&project=" . $res->project_prefix . "'><span alt='Data' class='dashicons dashicons-chart-area' style='padding-right:10px;font-size:25px'></a>";
                    echo"<a alt='Search Paps' href='" . get_site_url() . "/wp-admin/admin.php?page=project-info&project=" . $res->project_prefix . "&tab=search'><span class='dashicons dashicons-search' style='padding-right:10px;font-size:25px'></span></a> ";
                    echo"<a alt='Settings' href='" . get_site_url() . "/wp-admin/admin.php?page=project-info&project=" . $res->project_prefix . "&tab=settings'><span class='dashicons dashicons-admin-generic' style='padding-right:10px;font-size:25px'></span></a> ";
                echo"</td>";
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
