<?php

function job_forms() 
{
    global $wpdb;
    $tablename = $wpdb->prefix.'job_form_data';
    
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
         <h2>Job Attributes Forms</h2>
    <?php
    if($result){
        ?>
       
        <table class="form-table job_all_forms_table">
        <tr>
            <th>Form Name</th>
            <th>Job Attribute</th>
            <th>Action</th>
        </tr>
        <?php
        foreach($result as $row){
            
            if($row->job_attribute){
                
            $term = get_term( $row->job_attribute );
            
                if($term){
                     $job_attr=$term->name;
                }
            }
            else{
               $job_attr=''; 
            }
            
            
            ?>
            <tr>
            <td><?php echo $row->name; ?></td>
            <td><?php echo $job_attr; ?></td>
            <td><a href="<?php echo admin_url('admin.php'); ?>?page=job_form_edit&id=<?php echo $row->id; ?>">Edit</a></td>
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
        <h4>No Form Found Now!</h4>
        <?php
    }

 ?>
 </div>
 <?php
}
?>