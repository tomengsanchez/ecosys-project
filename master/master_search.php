<?php 
function master_search(){
    $result = array();
    if($_GET['searchQ']){
        $searchQ = array( 
            'orderby'=>array('meta_key'=>'nickname'),
            'order'=>'ASC',
            'meta_query' => array(
                    'relation' => 'OR',
                    array(
                            'key'     => 'first_name',
                            'value'   => $_GET['searchQ'],
                            'compare' => 'LIKE'
                    ),
                    array(
                            'key'     => 'last_name',
                            'value'   => $_GET['searchQ'],
                            'compare' => 'LIKE'
                    ),
                    array(
                            'key'     => 'barangay',
                            'value'   => $_GET['searchQ'],
                            'compare' => 'LIKE'
                    ),
                    array(
                            'key'     => 'nickname',
                            'value'   => $_GET['searchQ'],
                            'compare' => 'LIKE'
                    ),
                    array(
                            'key'     => 'paps_status',
                            'value'   => $_GET['searchQ'],
                            'compare' => 'LIKE'
                    )
    
            )
        );
        
        $userQuery = new WP_User_Query( $searchQ );
        $result = $userQuery->get_results();
    }
    $queryNonce = wp_create_nonce(get_current_user_id(  ) . "ajax_query");
    ?>
    <script type='text/javascript'>
        $(document).ready(function(){
            $('#searchQ').on('keypress',function(e){
                if(e.which=='13'){
                    $('#searchResult').html('<div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div>');
                    $.ajax({
                        type:'POST',
                        data:{
                            searchQ : $('#searchQ').val()
                        },
                        url:'<?php echo get_admin_url( )?>/admin-ajax.php?action=master_search',
                        success:function(r){
                            $('#searchResult').html(r);
                        }
                    });
                }
            });
            // $('.ses_button').click(function(){
            //     var title = "SES Entries for "  + $(this).attr('full_name');
            //     $('#ses_modal').modal('toggle');
            //     $('.modal-title').html(title);
            //     $('#ses_modal .modal-dialog .modal-content .modal-body').html('<div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div><div class="spinner-grow" role="status"></div>');
            //     user_id= $(this).attr('user_id');
            //     $.ajax({
            //         type:'POST',
            //         data : {
            //             "_nonce" : "<?php echo $queryNonce;?>",
            //             uid:user_id
            //         },
            //         url : '<?php echo get_admin_url( )?>/admin-ajax.php?action=get_entries_by_form',
            //         success:function(r){
                        
            //             $('#ses_modal .modal-dialog .modal-content .modal-body').html(r);
            //         }
            //     });
            // });
        });
    </script>
    
    <div class='container'>
    <h4>Master Search
    </h4>
    
        <div class='form-group' type='POST' action=''>
        <label for='searchQ'>Search for : </label>

            <input type='hidden' name='page' value='master-search'>
            <input class='form-control' type='text' id='searchQ' name='searchQ' size='50' placeholder='Enter Control# or Name or Lastname then Press Enter'>
            <small>Enter Control# or Name or Lastname then Press Enter</small>
        </div>
    
    <div class='modal fade' id='ses_modal' role='dialog'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='modal-header'>
                    <h5 class="modal-title" id="exampleModalLongTitle">SES entries</h5>
                </div>
                <div class='modal-body'>
                </div>
                
            </div>
        </div>
        
    </div>
        <div id='searchResult'>
            
        </div>
    </div>
    
   
    <?php 
}
?>