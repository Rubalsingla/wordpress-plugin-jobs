<?php


/* Template Name: job-detail */

get_header();


if(isset($_GET['id']))
{
    
    $postid= $_GET['id'];
    $current_user = wp_get_current_user();
    $firstname=$current_user->user_login;
    $date = date('M d,Y @ h:i');
    
     function setPostViews($postID) {
        $count_key = 'job_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '1');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    
    setPostViews($postid);
    
    $postcount=get_post_meta($postid, 'post_views_count', true);
    $application_url = site_url('/apply/');
    ?>
    
    
    <section class="wanted-farm-sec">
        <div class="container">
            <div class="wanted-farm">
                <div class="wanted-content">
                    <h1><?php echo get_the_title($postid) ? get_the_title($postid): ''  ?></h1>
                   
                    <div class="wanted-ct-button"
                      <i class="fa fa-map-marker" aria-hidden="true"></i><?php echo get_post_meta($postid,'job_location',true); ?>
                    </div>
                    <div class="wanted-ct-button">
                       <i class="fa fa-calendar" aria-hidden="true">
                </i>Applications for this job close: 
              
                <?php
                
                //echo get_post_meta($postid,'job_expiry',true);
                $today = date("Y-m-d");
                $expire = get_post_meta($postid,'job_expiry',true) ? get_post_meta($postid,'job_expiry',true):'';
                $today_time = strtotime($today);
                $expire_time = strtotime($expire);
        
                if ($expire_time < $today_time) { 
                   
                 
                     echo "Applications for this job closed";
                }
                else{
                    $date=date_create(get_post_meta($postid,'job_expiry',true));
                    echo date_format($date,"d/m/Y");
                }
                      
                ?>
              
              
                    </div>
                </div>
                <div class="wanted-content-image">
                    <?php if (has_post_thumbnail($postid)) { ?>
                            <img src="<?php echo get_the_post_thumbnail_url($postid); ?>" class="fj-card-img-top" alt="<?php echo the_title(); ?>">
                        <?php } else { ?>
                            <img src="<?php echo plugins_url(). '/job-openings/public/images/no-image.png'; ?>">
                        <?php } ?>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="harvest-sec">
        <div class="container">
            <div class="harvest-content">
                 <div class="inner-havest-ct">
                <?php 
                $my_post_content = apply_filters('the_content', get_post_field('post_content', $postid));
            
                echo $my_post_content ? $my_post_content:'----'; ?>
                </div>
                <div class="inner-havest-ct">
                    <h3>The Benefits:</h3>
                   <?php echo get_post_meta($postid,'benefits',true) ? get_post_meta($postid,'benefits',true):'---'; ?>
                    
                   
                </div>
                <div class="inner-havest-ct">
                    <h2>Experience/Skills & General Requirements</h2>
                    <?php echo get_post_meta($postid,'experience',true) ? get_post_meta($postid,'experience',true):'---'; ?>
                    
                </div>
                
                <div class="harvest-button">
                    <a href="<?php echo esc_url(add_query_arg(array('postID' => $postid), $application_url)); ?>" class="apply-btn">Apply Now</a>
                    
                </div>
            </div>
        </div>
    </section>
    
    <?php
    


 
}

get_footer();
  ?>




