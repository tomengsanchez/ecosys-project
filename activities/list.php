<?php 

?>
<h1>Activity List</h1>
<script>
jQuery(document).ready(function(){
    $("#list").dataTable();
});
</script>
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