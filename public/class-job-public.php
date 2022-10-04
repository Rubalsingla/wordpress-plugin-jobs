<?php

class Job_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;
    private $connectionString;
   
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
       
		//$this->move_to_unifier(11626);
        
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

         wp_enqueue_style('style-css', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
         wp_enqueue_style('style-css-boot', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), $this->version, 'all');
         wp_enqueue_style('style-css-boot', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
         wp_enqueue_style('style-css-res', plugin_dir_url(__FILE__) . 'css/responsive.css', array(), $this->version, 'all');
         wp_enqueue_style('my_custom_style-toast', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css');
         wp_enqueue_style('my_custom_style-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');

         
         





    }

     public function enqueue_script(){
         
         

        wp_enqueue_script($this->plugin_name . 'jquery', plugin_dir_url(__FILE__) . 'js/jquery.js', array('jquery'), $this->version, true);
        wp_localize_script($this->plugin_name, 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        
        
        wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/custom.js');
        wp_enqueue_script($this->plugin_name.'toast','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'toast-latest','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array('jquery'), $this->version, true);
        
        
       
        

     }

    public function wpa3396_page_template($page_template){



         if ( is_page( 'apply' ) ) {

            $page_template = dirname( __FILE__ ) . '/templates/apply.php';
         }
         if ( is_page( 'job-detail' ) ) {

            $page_template = dirname( __FILE__ ) . '/templates/job-detail.php';
         }
        return $page_template;
    }

    public function apply_form_ajax(){

    if(isset($_POST))
    {
        $data_files=array();
        $cover_file=array();
        if(isset($_FILES))
        {
            if(!function_exists('wp_handle_upload')){
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }
            $files = $_FILES;
            // echo"<pre>";
            // print_r($files);
            // echo"</pre>";
            // die('dhhd');
            foreach($files as $file)
            {
               if(isset($file['name']))
               {
                  
                    foreach($file['name'] as $key => $value )
                    {
                        
                        if ($file['name'][$key]) 
                        { 
                            $upload_overrides = array('test_form' => false);
                            $singlefile = array( 
                                'name' => $file['name'][$key],
                                'type' => $file['type'][$key], 
                                'tmp_name' => $file['tmp_name'][$key], 
                                'error' => $file['error'][$key],
                                'size' => $file['size'][$key]
                            ); 
                             $file_info = wp_handle_upload($singlefile, $upload_overrides);
                             if(!empty($file_info)){
                                
                                 if(isset($file_info['error'])){
                                     
                                    $result=json_encode(array("status"=>false,"code"=>400,"message"=>"Error in file upload"));
                                    echo $result;
                                    die();
                                 }
                                 else{
                                     
                                     $data_files[]=array('file_url'=>$file_info['url'],'file'=>$file_info['file']);
                                 }
                                 
                             }
                        }
                    }
                    if(is_array($file['name'])){
                    }
                    else{
                        if($file['name']){
                        $upload_overrides = array('test_form' => false);
                        $singlecover = array( 
                            'name' => $file['name'],
                            'type' => $file['type'], 
                            'tmp_name' => $file['tmp_name'], 
                            'error' => $file['error'],
                            'size' => $file['size']
                        ); 
                        $file_info = wp_handle_upload($singlecover, $upload_overrides);
                        if(!empty($file_info)){
                             
                             if(isset($file_info['error'])){
                                 
                                $result=json_encode(array("status"=>false,"code"=>400,"message"=>"Error in file upload"));
                                echo $result;
                                die();
                             }
                             else{
                                 $cover_file[]=array('file_url'=>$file_info['url'],'file'=>$file_info['file']);
                                 
                             }
                             
                         }
                    }
                        
                    }
                }
            }
        }
        
        //parse_str($_POST, $postdata);
        $postdata=$_POST;
         
        $i=1;
        global $postid;
        foreach($postdata as $key => $val)
        {
            if($i==1)
            {
                // Create post object
                $my_post = array(
                  'post_title'    => $val,
                  'post_status'   => 'publish',
                  'post_type' => 'jobs-application'
                );
                         
                // Insert the post into the database
                global $postid;
                $postid=wp_insert_post( $my_post );
                update_post_meta( $postid, $key, $val);
                
            }
            else{
                if($key=='job_opening_id'){
                    update_post_meta( $postid,'job_opening_id', $val);
                }
                update_post_meta( $postid, $key, $val);
            }
            $i=$i+1;
            
        }
        
       
        if($postid){
            update_post_meta( $postid,'job_status','inprogress');
            
            $current_user = wp_get_current_user();
            $firstname=$current_user->user_login;
            $date = date('M d,Y @ h:i');
            
            if ( metadata_exists( 'post', $postid, 'activity_log' ) ) 
            {
                
                $activity_log=get_post_meta($postid, 'activity_log', true);
                $mainarray=unserialize($activity_log);
                $user_view_activity=array("message"=>'Application Submitted',"username"=>$firstname,"date"=>$date);
                array_push($mainarray,$user_view_activity);
                $activity_log=serialize($mainarray);
                update_post_meta($postid, 'activity_log', $activity_log);
            }
            else{
                    $mainarray=array();
                    $user_view_activity=array("message"=>'Application Viewed',"username"=>$firstname,"date"=>$date);
                    array_push($mainarray,$user_view_activity);
                    $activity_log=serialize($mainarray);
                    add_post_meta($postid, 'activity_log', $activity_log);
            }
            
            $application_result=json_encode(array("status"=>true,"code"=>200,"message"=>"Job Application Submitted",'post_id'=>$postid));
        }
        else{
            $application_result=json_encode(array("status"=>true,"code"=>200,"message"=>"Something Went Wrong!",'post_id'=>$postid));
        }
        
        if(!empty($data_files)){
            
            $resume_files=serialize($data_files);
            update_post_meta( $postid,'resume_files',$resume_files);
            
        }
         if(!empty($cover_file)){
            
            $cover_file=serialize($cover_file);
            update_post_meta( $postid,'cover_file',$cover_file);
            
        }
        
         echo $application_result;
         die();
        }
    }
    public function search_title_ajax()
    {	
        $application_url = site_url('/apply/');
        if(isset($_POST))
        {
            
                if(isset($_POST['title']) && !empty($_POST['title'])){
                    $srchtitle = $_POST['title'];
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        's' => $_POST['title'],
                    );
                    
                }
                else if(isset($_POST['location']) && !empty($_POST['location'])){
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        'meta_query' =>array(
                            array(
                                'key'     => 'job_location',
                                'value'   => $_POST['location'],
                                'compare' => 'LIKE'
                            ),
                        )
                    );
                    
                }else{
                    
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                    );
                }
                
                if(!empty($_POST['title']) && !empty($_POST['location'])){
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        's' => $_POST['title'],
                        'meta_query' =>array(
                            array(
                                'key'     => 'job_location',
                                'value'   => $_POST['location'],
                                'compare' => 'LIKE'
                            ),
                        )
                    );
                }
                if(isset($_POST['type']) && !empty($_POST['type'])){
                    
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        'meta_query' =>array(
                            array(
                                'key'     => 'job_type',
                                'value'   => $_POST['type'],
                                'compare' => 'LIKE'
                            ),
                        )
                    );
                    
                }
                if(isset($_POST['type']) && !empty($_POST['title']) && !empty($_POST['location'])){
                    
                    $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        's' => $_POST['title'],
                        'meta_query' =>array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'job_type',
                                'value'   => $_POST['type'],
                                'compare' => '='
                            ),
                            array(
                                'key'     => 'job_location',
                                'value'   => $_POST['location'],
                                'compare' => 'LIKE'
                            ),
                        )
                    );
                }
                if(isset($_POST['type'])){
                    if(!empty($_POST['title']) && !empty($_POST['type'])){
                        $args = array(
                            'post_type' => 'jobs-openings',
                            'hide_empty' => false,
                            'post_status' => 'publish',
                            's' => $_POST['title'],
                            'meta_query' =>array(
                                array(
                                    'key'     => 'job_type',
                                    'value'   => $_POST['type'],
                                    'compare' => '='
                                ),
                            )
                        );
                    }
                    if(!empty($_POST['location']) && !empty($_POST['type'])){
                        $args = array(
                        'post_type' => 'jobs-openings',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        's' => $_POST['title'],
                        'meta_query' =>array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'job_type',
                                'value'   => $_POST['type'],
                                'compare' => '='
                            ),
                            array(
                                'key'     => 'job_location',
                                'value'   => $_POST['location'],
                                'compare' => 'LIKE'
                            ),
                        )
                        );
                    }
                }
                
                $my_query = new WP_Query($args);
                
                if ($my_query->have_posts())
                {
                    while ($my_query->have_posts()): 
                        $my_query->the_post();
                        $post_id = get_the_id();
                        $get_job_set_exp_date = get_post_meta($post_id, 'job_expiry', true);
                        $job_set_exp_date = date('F j, Y', strtotime($get_job_set_exp_date));
                        
                        $resultdata="<div class='colu-4'><div class='farmjob-card'><div class='farmjob-card-body'><a href='".site_url('job-detail/?id='.$post_id)."'>";
                        if (has_post_thumbnail()) {
                                $resultdata .="<img src='". get_the_post_thumbnail_url(get_the_ID())."' class='fj-card-img-top' alt='". get_the_title()."'>";
                                }else{ 
                                $resultdata .="<img src='".plugins_url()."/job-openings/public/images/no-image.png' class='fj-card-img-top' alt='...'>";
                                }
                        $resultdata .="</a>";
                        $resultdata .="<a href='".get_the_permalink()."'>";
                                $resultdata .="<h3 class='farmjob-card-title'>".get_the_title();
                                if(!empty($job_type->name)){
                                    $resultdata .="<span>('.$job_type->name.')</span>";
                                }
                                    $resultdata .="</h3></a>";
                        $resultdata .="<p class='farmjob-card-text fj-location'><i class='fa fa-map-marker' aria-hidden='true'></i>". get_post_meta( get_the_id(),'job_location',true)."</p>";
                        $resultdata .="<p class='farmjob-card-text fj-deadline'><i class='fa fa-calendar' aria-hidden='true'></i>".$job_set_exp_date."</p>";
                        
                        $resultdata .="<p class='farmjob-card-price'>".get_post_meta( get_the_id(),'job_price',true)."</p>";
                        
                        $resultdata .="</div><a class='apply-btn' href='".esc_url(add_query_arg(array('postID' => get_the_id()), $application_url))."'>Apply Now</a></div></div>";
                        
                        $result[]=array(stripslashes($resultdata));
                        
                        endwhile;
                        wp_send_json($result);
                        
                }
        }
        die();
    }
                    
	
}