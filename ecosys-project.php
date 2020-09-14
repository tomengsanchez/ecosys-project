<?php 
/**
 * Plugin Name: Ecosys Project Management
 * Description:       Add Ecosys Projects
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tomeng Sanchez Pogi
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 * 
 * */


function ecosys_project_add_menu(){
    add_menu_page('Welcome to Ecosys Project Management','Ecosys Project Manager','manage_options','ecosys-project-page','ecosys_main_function','dashicons-welcome-widgets-menus','200');
}
add_action('admin_menu','ecosys_project_add_menu');
function ecosys_main_function(){
    print_r($_POST);
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
    <?php
}

?>
