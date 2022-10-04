<?php 
function job_listing(){
    ob_start(); 

    global $wpdb;
    $tablenametype = $wpdb->prefix.'job_types';
    $jobtypes = $wpdb->get_results("SELECT * FROM $tablenametype");
    ?>
<div class="custom-container">
    <div class="custom-form-title">
        <h1>Farm Jobs</h1>
        <div class="custom-form-title-image">
            <img src="<?php echo plugins_url(). '/job-openings/public/images/farm_logo_2.png'; ?>">
        </div>
    </div>
   <form id="cust_srch" method="post">
            <div class="search-key-drop" style="margin-bottom: 45px;">
                <div class="search-farm-bar">
                    <input type="text" placeholder="Keyword" name="the_title" id="the_title_id">
                </div>
                <div class="key-farm-locate">
                    <input type="text" placeholder="Find Location" name="the_location" id="the_location_id">
                </div>
                <?php $types = get_terms('job_type', array('hide_empty' => false));
                //var_dump($types);
                ?>
                <select id="farm-drop-form" name="the_type">
                    <option value="">Type</option>
                    <?php
                        if(!empty($jobtypes)){
                            
                            foreach($jobtypes as $type){
                                
                                ?><option value="<?php echo $type->name; ?>"><?php echo $type->name; ?></option>
                                <?php
                            }
                            
                        }
                        ?>
                    
                  
                </select>
            </div>
            
        </form>
        <?php

        // define form destination url
        $application_url = site_url('/apply/');
        //$taxonomy = 'job_type'; // this is the name of the taxonomy
        $args = array(
            'post_type' => 'jobs-openings',
            'posts_per_page' => '9',
            //'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'paged' => get_query_var('paged'),
            'post_status' => array('publish'),
            // 'cat' => get_query_var('cat')
        );
        $my_query = new WP_Query($args);
        $count = $my_query->found_posts; ?>
        <div class="lf-farmjob-pagination" id="lf-farmjob-pagination-id">
            <div class="farm-job-flex"><?php
                                        if ($my_query->have_posts()) :
                                            while ($my_query->have_posts()) : $my_query->the_post(); ?>
                        <?php
                                                $post_id = get_the_id();
                                                //$job_type = get_field('job_type');
                                                //$job_set_exp = get_post_meta($post_id, 'awsm_set_exp_list', true);
                                                $get_job_set_exp_date = get_post_meta($post_id, 'job_expiry', true);
                                                $job_set_exp_date = date('F j, Y', strtotime($get_job_set_exp_date));
                                                //$job_set_exp_display = get_post_meta($post_id, 'awsm_exp_list_display', true);

                        ?>
                        <div class="colu-4 custom-apply-form">
                            <div class="farmjob-card">

                                <div class="farmjob-card-body">
                                    <?php  $site_url=site_url('job-detail/?id='.get_the_ID()); ?>
                                    <a href="<?php echo $site_url; ?>">
                                        <?php if (has_post_thumbnail()) { ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" class="fj-card-img-top" alt="<?php echo the_title(); ?>">
                                        <?php } else { ?>
                                            <img src="<?php echo plugins_url(). '/job-openings/public/images/no-image.png'; ?>">
                                        <?php } ?>
                                    </a>
                                    <a href="<?php the_permalink(); ?>">
                                        <h3 class="farmjob-card-title"><?php echo the_title(); if(!empty($job_type->name)){ ?> <span>(<?php echo esc_html($job_type->name); ?>)</span><?php } ?></h3>
                                    </a>
                                    <p class="farmjob-card-text fj-location"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo get_post_meta( $post_id,'job_location',true); ?></p>
                                    <p class="farmjob-card-text fj-deadline"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo $job_set_exp_date;
                                                // if ($job_set_exp == 'set_listing') {
                                                //     echo "Applications close :" . $job_set_exp_date . " ";
                                                // } else {
                                                //     echo "Ongoing.";
                                                // } ?>
                                    </p>
                                    <p class="farmjob-card-price"><?php echo get_post_meta( $post_id,'job_price',true); ?></p>
                                </div>
                                <a href="<?php echo esc_url(add_query_arg(array('postID' => $post_id), $application_url)); ?>" class="apply-btn">Apply Now</a>
                            </div>
                        </div>
                <?php
                                            endwhile;
                                            wp_reset_postdata();
                                        endif;
                                        the_posts_navigation();
                ?>
            </div>

            <div class="lf-pagi-num">
                <div class="colu-6 fj-number custom-fj-number">
                    <h4><?php echo $my_query->post_count; ?> of <?php echo $count; ?> Farm Jobs</h4>
                </div>

                <div class="colu-6 pagination custom-pagination">
                    <?php
                    // $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    echo paginate_links(array(
                        'total' => $my_query->max_num_pages,
                        'prev_text'    => __('Previous'),
                        'next_text'    => __('Next'),
                        // 'current' => $paged,
                        'type' => 'plain',
                        'base' => get_pagenum_link(1) . '%_%',
                        'format' => '/page/%#%',
                    ));
                    ?>
                </div>
            </div>

        </div>
</div>
<script>	
jQuery(document).ready( function($) {
    jQuery('#the_title_id, #the_location_id').on('keyup',function(e){
        e.preventDefault();
       // if($(this).val().length >= 1){
            var title = $("#the_title_id").val();
            var location =  $("#the_location_id").val();
            
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data:{title:title,location:location, action: "search_title_ajax"},
                method: "POST",
                
                success: function(response) {
                    console.log(response);
                    jQuery(".farm-job-flex").html('');
                    jQuery(".lf-pagi-num").html('');
                    jQuery(".farm-job-flex").html(response);
                },
                error:function(res){
                    console.log("error!");
                }
            });
        //}
        if($(this).val().length == 0){
            window.location.reload();
        }
    });
    
    $('#farm-drop-form').on('change', function(e){
       
        var type = $(this).val();
        
       if(type != ''){
        var title = $("#the_title_id").val();
        var location =  $("#the_location_id").val();
        
       jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data:{title:title,location:location,type:type, action: "search_title_ajax"},
                method: "POST",
                
                success: function(response) {
                    console.log(response);
                    jQuery(".farm-job-flex").html('');
                    jQuery(".lf-pagi-num").html('');
                    jQuery(".farm-job-flex").html(response);
                },
                error:function(res){
                    console.log("error!");
                }
            });
       }else{
           window.location.reload();
       }
       
    });    
        
    
});
</script>
    <?php

        $farm_job_pagination = ob_get_clean();
        return $farm_job_pagination;
         //return ob_get_clean();
}
add_shortcode('job-listing', 'job_listing');?>