<?php 
//define( 'WP_DEBUG', true );


?>
<h5>Activity List</h5>
<script>
jQuery(document).ready(function(){
    jQuery("#list").dataTable();
    jQuery('#addNewEvents').click(function(){
        alert(1);
    });
    
});
</script>
<hr>
<button class='button' id='addNewEvents'>Add New Events</button>
<hr>
<table id='list' class='fluid'>
    <thead>
        <th>Date</th>    
        <th>Type</th>
        <th>Coordinator</th>
        <th>Location</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <th>Date</th>    
        <th>Type</th>
        <th>Coordinator</th>
        <th>Location</th>
    </tfoot>
</table>