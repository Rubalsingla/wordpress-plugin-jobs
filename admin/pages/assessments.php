<?php

function assessments() 
{
    global $wpdb;
    
    function get_trait_name($trait_id){
        
       global $wpdb;    
       $traitname = $wpdb->prefix.'job_traits'; 
       $qry="select * from $traitname where id='$trait_id'";
       $result=$wpdb->get_results($qry, object);
       if(!empty($result)){
           return $result[0]->traits;
       }
       else{
           return"";
       }
        
    }
    $tablename = $wpdb->prefix.'job_assesments';
    
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 20;
    $offset = ($pagenum-1) * $limit;
    $total = $wpdb->get_var( "SELECT COUNT(*) FROM $tablename" );
    $num_of_pages = ceil( $total / $limit );

    $qry="select * from $tablename  order by id desc LIMIT $offset, $limit";
    $result=$wpdb->get_results($qry, object);
   // print_r($result);
   ?>
    <div class="job_all_forms_div">
         <h2>Assessments</h2>
         <a href="<?php echo admin_url('admin.php'); ?>?page=add_assessment">Add Assessment</a>
    <?php
    if($result){
        ?>
       
        <table class="form-table job_all_forms_table">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Traits</th>
            <th>Action</th>
        </tr>
       
       <?php
       foreach($result as $res){
       ?>
            <tr>
            <td><?php echo $res->name; ?></td>
            <td><?php echo $res->type; ?></td>
            <td><?php echo get_trait_name($res->traits); ?></td>
            <td><a href="<?php echo admin_url('admin.php'); ?>?page=edit_assessment&id=<?php echo $res->id; ?>">Edit</a></td>
            </tr>
        <?php
       }
       ?>
            
        </table>
        
        <?php

            //Link for Pagination

        $page_links = paginate_links( array(
            'base'               => add_query_arg( 'pagenum', '%#%' ),
            'format'             => '',
            'prev_text'          => __( '&laquo;', 'aag' ),
            'next_text'          => __( '&raquo;', 'aag' ),
            'total'              => $num_of_pages,
            'current'            => $pagenum,               
            'base'               => add_query_arg( 'pagenum', '%#%' ),
            'format'             => '',
            'prev_next'          => true,
            'prev_text'          => __( '&larr;', 'aag' ),
            'next_text'          => __( '&rarr;', 'aag' ),
            'before_page_number' => '<li><span class="page-numbers btn btn-pagination btn-tb-primary">',
            'after_page_number'  => '</span></li>'
        ) );
            if ( $page_links ) {
                ?>
                <br class="clear">
            <nav id="archive-navigation" class="paging-navigation tbWow fadeInUp" role="navigation" style="visibility: visible; animation-name: fadeInUp;">
                <ul class="page-numbers">
                    <?php echo $page_links; ?>
                </ul>
            </nav>
        <?php   }
    }
    else{
         ?>
        <h4>No Assessment Found Now!</h4>
        <?php
    }

 ?>
 </div>
 <?php
}

?>