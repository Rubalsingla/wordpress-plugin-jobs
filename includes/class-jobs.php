<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.aarvkininfotech.com
 * @since      1.0.0
 *
 * @package    Job
 * @subpackage Job/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Job
 * @subpackage Job/includes
 * @author     Aarvikinfotech <info@aarvikinfotech>
 */
class Job {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Job_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('Job_VERSION')) {
            $this->version = '1.0.0';
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'Jobs';
        $this->load_dependencies();
        //$this->job_form_data();
        $this->define_public_hooks();
        $this->define_admin_hooks();
        $this->filters = array();
       

    }

    private function load_dependencies() {


        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-job-loader.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/shortcode/job-listing.php';
        //require_once plugin_dir_path(dirname(__FILE__)) . 'public/templates/job-detail.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-job-public.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-job-admin.php';

        $this->loader = new Job_Loader();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }
        
        $this->loader->run();
    }

     private function define_public_hooks() {

         $plugin_public = new Job_Public($this->get_plugin_name(), $this->get_version());


         $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
         $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_script');


        $this->loader->add_filter('page_template',$plugin_public,'wpa3396_page_template');
        

        $this->loader->add_action( 'wp_ajax_apply_form_ajax',$plugin_public, 'apply_form_ajax');
        $this->loader->add_action( 'wp_ajax_nopriv_apply_form_ajax',$plugin_public,'apply_form_ajax');
        
		$this->loader->add_action( 'wp_ajax_search_title_ajax',$plugin_public, 'search_title_ajax');		
		$this->loader->add_action( 'wp_ajax_nopriv_search_title_ajax',$plugin_public,'search_title_ajax'); 
		
		// Remove issues with prefetching adding extra views
        //$this->loader->remove_action( 'wp_head', $plugin_public ,'adjacent_posts_rel_link_wp_head', 10, 0);
    

     }

    private function define_admin_hooks() {

    $plugin_admin = new Job_Admin($this->get_plugin_name(), $this->get_version());
    // $this->loader->add_action( 'init',$plugin_admin, 'Bike_taxonomies_motorcycle', 0 );
    // $this->loader->add_action( 'init',$plugin_admin, 'Bike_taxonomies_motorcycle_owners', 0 );
    $this->loader->add_action( 'init',$plugin_admin ,'Job_post_document',0 );
    $this->loader->add_action( 'init',$plugin_admin ,'Job_post_applications',0 );
    //$this->loader->add_action( 'init',$plugin_admin ,'Job_post_form',0 );
   // $this->loader->add_action( 'init',$plugin_admin, 'Job_taxonomies_document', 0 );
    $this->loader->add_action('init',$plugin_admin,'add_get_val');

   /* $this->loader->add_action( 'init',$plugin_admin, 'Bike_taxonomies_location', 0 );*/
   /* $this->loader->add_action( 'init',$plugin_admin, 'Bike_taxonomies_location_bike', 0 );*/
    /*$this->loader->add_action( 'init',$plugin_admin ,'Bike_post_location',0 );*/

    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
    //$this->loader->add_action('pre_post_update', $plugin_admin,'do_something_with_a_post', 10, 2);
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'job_form_save' );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'job_form_get' );
    $this->loader->add_action( 'wp_ajax_formdata_form_ajax',$plugin_admin, 'formdata_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_formdata_form_ajax',$plugin_admin,'formdata_form_ajax');
    $this->loader->add_action( 'wp_ajax_main_formdata_form_ajax',$plugin_admin, 'main_formdata_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_main_formdata_form_ajax',$plugin_admin,'main_formdata_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_main_formdata_get_form_ajax',$plugin_admin, 'main_formdata_get_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_main_formdata_get_form_ajax',$plugin_admin,'main_formdata_get_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_edit_formdata_ajax',$plugin_admin, 'edit_formdata_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_edit_formdata_ajax',$plugin_admin,'edit_formdata_ajax');
    
    
    $this->loader->add_action( 'wp_ajax_editdata_formdata_form_ajax',$plugin_admin, 'editdata_formdata_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_editdata_formdata_form_ajax',$plugin_admin,'editdata_formdata_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_download_formdata_ajax',$plugin_admin, 'download_formdata_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_download_formdata_ajax',$plugin_admin,'download_formdata_ajax');
    
    $this->loader->add_action( 'wp_ajax_mail_form_ajax',$plugin_admin, 'mail_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_mail_form_ajax',$plugin_admin,'mail_form_ajax');
    $this->loader->add_filter('pre_get_posts',$plugin_admin, 'post_types_admin_order');
    
    $this->loader->add_filter( 'manage_jobs-application_posts_columns',$plugin_admin, 'set_custom_edit_application_columns' );
    $this->loader->add_action( 'manage_jobs-application_posts_custom_column',$plugin_admin,'custom_application_column', 10, 2 );

    $this->loader->add_action( 'wp_ajax_jobtype_form_ajax',$plugin_admin, 'jobtype_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_jobtype_form_ajax',$plugin_admin,'jobtype_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_edit_jobtype_ajax',$plugin_admin, 'edit_jobtype_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_edit_jobtype_ajax',$plugin_admin,'edit_jobtype_ajax');
    
    $this->loader->add_action( 'wp_ajax_assesment_traits_form_ajax',$plugin_admin, 'assesment_traits_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_assesment_traits_form_ajax',$plugin_admin,'assesment_traits_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_assesment_form_ajax',$plugin_admin, 'assesment_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_assesment_form_ajax',$plugin_admin,'assesment_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_edit_assesment_form_ajax',$plugin_admin, 'edit_assesment_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_edit_assesment_form_ajax',$plugin_admin,'edit_assesment_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_update_traits_form_ajax',$plugin_admin, 'update_traits_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_update_traits_form_ajax',$plugin_admin,'update_traits_form_ajax');
    
    $this->loader->add_action( 'wp_ajax_deletejob_form_ajax',$plugin_admin, 'deletejob_form_ajax');
    $this->loader->add_action( 'wp_ajax_nopriv_deletejob_form_ajax',$plugin_admin,'deletejob_form_ajax');
    
    
    
    $this->loader->add_action('admin_menu', $plugin_admin,'my_admin_menu'); 
    
    
 



    /*$this->loader->add_action( 'admin_init',$plugin_admin, 'add_post_gallery_so_14445904' );
    $this->loader->add_action( 'admin_head-post.php',$plugin_admin, 'print_scripts_so_14445904' );
    $this->loader->add_action( 'admin_head-post-new.php',$plugin_admin, 'print_scripts_so_14445904' );
    $this->loader->add_action( 'save_post',$plugin_admin, 'update_post_gallery_so_14445904', 10, 2 );*/

  /*  add_action( 'admin_head-post.php', 'print_scripts_so_14445904' );
    add_action( 'admin_head-post-new.php', 'print_scripts_so_14445904' );*/

    $this->loader->add_action( 'admin_menu',$plugin_admin, 'register_my_custom_menu_page' );
    
//     add_action('load-index.php', 'dashboardcustomContent');
    
//     /* add content */
// function dashboardcustomContent() {
//   echo '<div><p>Custom Lorem Ipsum Content</p></div>';
// } 

    
    
    
    add_action('add_meta_boxes',function (){
        add_meta_box(
             'job-field',     
             'Job Details',     
             'jobs_custom_fields_html',     
             ['jobs-openings'],     
             'advanced' 
        );
    });

    add_action('add_meta_boxes',function (){
        add_meta_box(
             'form-field',     
             'Create Form',     
             'jobs_custom_form',     
             ['job-form'],     
             'advanced' 
        );
    });

    add_action('add_meta_boxes',function (){
        add_meta_box(
             'side',     
             'Action',     
             'action_custom_fields_html',     
             ['jobs-application'],     
              'side', // 
              'core'
        );
    });
    
    add_action('add_meta_boxes',function (){
        add_meta_box(
             'sside',     
             'Activity Logs',     
             'activity_custom_fields_html',     
             ['jobs-application'],     
             'side'
             
        );
    });

    add_action('add_meta_boxes',function (){
        add_meta_box(
             'application-field',     
             'Application Details',     
             'application_custom_fields_html',     
             ['jobs-application'],     
             'advanced' 
        );
    });
    
    add_action('add_meta_boxes',function (){
       add_meta_box( 'awsm-status-meta-applicant', esc_html__( 'Job Opening Details', 'job_openings' ), array( $this, 'awsm_job_status' ), 'jobs-application', 'side', 'low' );
    });
    
    
    
   
    
    add_action('wp_dashboard_setup', 'open_jobs_dashboard_widgets');
  
    function open_jobs_dashboard_widgets() {
    global $wp_meta_boxes;
    

      // Add custom dashbboard widget.
      add_meta_box( 'dashboard_widget_example',
        __( 'Job Info', 'example-text-domain' ),
        'job_info',
        'dashboard',
        'normal',
        'default'
      );
     
     wp_add_dashboard_widget('custom_help_widget', 'Open Jobs', 'open_jobs');
     add_meta_box( 'recent_candidate', 'Recent Candidates', 'recent_candidate', 'dashboard', 'side', 'high' );
     //add_meta_box( 'main_widget', 'Job info', 'job_info', 'dashboard', 'normal', 'high' );
    }
    function job_info() {
        
        $current_user = wp_get_current_user();
        $firstname=$current_user->user_login;
        
        $args = array(
            'post_type' => 'jobs-application',
            'hide_empty' => false,
            'post_status' => 'publish',
            'orderby'        => 'id',
            'order'          => 'desc',
            'meta_query' =>array(
                array(
                    'key'     => 'job_status',
                    'value'   => 'inprogress',
                    'compare' => '='
                ),
            )
        );
        $my_query = new WP_Query($args);
        $total_applications_inprogress=$my_query->found_posts;
        
        $total_jobs = array(
                'post_type' => 'jobs-openings',
                'hide_empty' => false,
                'post_status' => 'publish',
                'posts_per_page' => '5',
                'orderby'        => 'id',
                'order'          => 'desc',
                'meta_query' =>array(
                    array(
                        'key'     => 'job_expiry',
                        'value'   => date('Y-m-d'),
                        'compare' => '>='
                    ),
                )
            );
            $total_jobs = new WP_Query($total_jobs);
            $total_jobs=$total_jobs->found_posts;
        
        ?> 
        <div class="dashboard_wid_wrap">
            <div class="main_candi_sec">
            <span class="hi_section"> Hi, <?php echo $firstname ? $firstname:''; ?></span>
            <span class="candidate_review_section"> <?php if($total_applications_inprogress) { echo"You have $total_applications_inprogress new candidate to review"; } ?></span>
            <span class="all_candidates"><a href="<?php echo admin_url('edit.php?post_type=jobs-application'); ?>">View all candidates</a></span>
        </div>
        <div class="main_jobs_sec">
            <?php
            if($total_jobs){
                ?><span><?php echo $total_jobs; ?></span><h4>Open Jobs</h4><?php
            }
            ?>
        </div>
        </div>
        
        
        <?php
     
    }
    
    
    
    
    
    
    function recent_candidate(){
        
         $args = array(
                'post_type' => 'jobs-application',
                'hide_empty' => false,
                'post_status' => 'publish',
                'posts_per_page' => '5',
                'orderby'        => 'id',
                'order'          => 'desc'
            );
            $my_query = new WP_Query($args);
             if ($my_query->have_posts())
            {
                function time_elapsed_string($datetime, $full = false) {
                    
                    $now = new DateTime;
                    $ago = new DateTime($datetime);
                    $diff = $now->diff($ago);
                
                    $diff->w = floor($diff->d / 7);
                    $diff->d -= $diff->w * 7;
                
                    $string = array(
                        'y' => 'year',
                        'm' => 'month',
                        'w' => 'week',
                        'd' => 'day',
                        'h' => 'hour'
                       
                    );
                    foreach ($string as $k => &$v) {
                        if ($diff->$k) {
                            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                        } else {
                            unset($string[$k]);
                        }
                    }
                
                    if (!$full) $string = array_slice($string, 0, 1);
                    return $string ? implode(', ', $string) . ' ago' : 'just now';
                }
                ?>
                 <table>
                     <thead>
                         <tr>
                        <th>Candidate</th>
                        <th>Position</th>
                        <th>Status</th>
                    </tr>
                     </thead>
                    
                    
                    <?php
                    
                    while ($my_query->have_posts()): 
                        $my_query->the_post();
                        $post_id = get_the_id();
                        $status = get_post_meta($post_id, 'job_status', true);
                        $job_opening_id = get_post_meta($post_id, 'job_opening_id', true);
                        $jobname=get_the_title($job_opening_id);
                        
                       
                        

                         ?>
                            <tr>
                                <td><?php echo get_the_title(); ?><span><?php echo time_elapsed_string(get_the_date()); ?></span></td>
                                <td><?php  if($jobname!='') { echo $jobname; } else{ echo"-----";} ?></td>
                               
                                <?php
                                if($status=='inprogress'){
                                     echo "<td><span class='inprogress'>In Progress</span></td>";
                                }
                                if($status=='shortlisted'){
                                     echo "<td><span class='shortlisted'>Shortlisted</span></td>";
                                }
                                if($status=='rejected'){
                                     echo "<td><span class='rejected'>Rejected</span></td>";
                                }
                                 if($status=='selected'){
                                     echo "<td><span class='selected'>Selected</span></td>";
                                }
                                ?>
                               
                            </tr>
                       <?php
                       
                        
                    endwhile;
                    
                    ?>
                    </table>
                   <div class="view_all_cls"> <a href="<?php echo admin_url('edit.php?post_type=jobs-application'); ?>">View all</a></div>
                    <?php
            }
            
    }
 
    function open_jobs() {
        
        
        $args = array(
                'post_type' => 'jobs-openings',
                'hide_empty' => false,
                'post_status' => 'publish',
                'posts_per_page' => '5',
                'orderby'        => 'id',
                'order'          => 'desc',
                'meta_query' =>array(
                    array(
                        'key'     => 'job_expiry',
                        'value'   => date('Y-m-d'),
                        'compare' => '>='
                    ),
                )
            );
            $my_query = new WP_Query($args);
            if ($my_query->have_posts())
            {
                ?>
                 <table>
                     <thead>
                          <tr>
                        <th>Position</th>
                        <th>Applications</th>
                        <th>Expiry</th>
                        <th>Views</th>
                    </tr>
                     </thead>
                   
                    
                    <?php
                    
                    while ($my_query->have_posts()): 
                        $my_query->the_post();
                        $post_id = get_the_id();
                        $get_job_set_exp_date = get_post_meta($post_id, 'job_expiry', true);
                        $job_views_count = get_post_meta($post_id, 'job_views_count', true);
                        global $wpdb;
                        $count = $wpdb->get_row("SELECT COUNT(*) AS THE_COUNT FROM $wpdb->postmeta WHERE (meta_key = 'job_opening_id' AND meta_value = $post_id)");
                        
                        $applications = array(
                        'post_type' => 'jobs-application',
                        'hide_empty' => false,
                        'post_status' => 'publish',
                        'meta_query' =>array(
                            array(
                                'key'     => 'job_opening_id',
                                'value'   => $post_id,
                                'compare' => '='
                            ),
                        )
                         );
                         
                        $applications_data = new WP_Query($applications);
                        $total_applications=$applications_data->found_posts;

                         ?>
                            <tr>
                                <td><?php echo get_the_title(); ?></td>
                                <td><?php  if($total_applications!='') { echo $total_applications; } else{ echo"0";} ?></td>
                                <td><?php echo $get_job_set_exp_date ? $get_job_set_exp_date:'------'; ?></td>
                                <td><?php echo $job_views_count ? $job_views_count:0; ?></td>
                            </tr>
                       <?php
                       
                        
                    endwhile;
                    
                    ?>
                    </table>
                   <div class="view_all_cls"> <a href="<?php echo admin_url('edit.php?post_type=jobs-openings'); ?>">View all</a></div>
                    <?php
            }
           
    }



        //Meta callback function
        function jobs_custom_fields_html($post){
            $cs_meta_val=get_post_meta($post->ID);
          

            global $wpdb;
            $tablename = $wpdb->prefix.'job_types';
            $jobtypes = $wpdb->get_results("SELECT * FROM $tablename");
            
            $assesment_table = $wpdb->prefix.'job_assesments';
            $assessments = $wpdb->get_results("SELECT * FROM $assesment_table");
            // echo"<pre>";
            // print_r($jobtypes);
            // echo"</pre>";

            ?>
            <table class="form-table">
               
                <tr>
                    <th><label for="job_id">Job ID</label></th>
                    <td>
                        <input type="text" name="job_id" id="job_id" class="regular-text" value="<?php if( isset( $post->ID)) echo $post->ID; ?>" readonly>
                        <span>This is system's auto generated Id</span>
                    </td>
                    
                </tr>
                <tr>
                    <th><label for="job_type">Job Assesments</label></th>
                    <td><select name="assessment" id="assessment" class="regular-text">
                        <option value="">Select Assesments</option>
                        <?php
                        if(!empty($assessments)){
                            
                            foreach($assessments as $assessment){
                                
                                ?><option value="<?php echo $assessment->id; ?>" <?php if(isset( $cs_meta_val['assessment'])) { if($cs_meta_val['assessment'][0]== $assessment->id) { echo 'selected'; } } ?>><?php echo $assessment->name; ?></option>
                                <?php
                            }
                            
                        }
                        ?>
                       
                        

                    </select>
                    </td>
                   
                </tr>
                <tr>
                    <th><label for="job_type">Job Type</label></th>
                    <td><select name="job_type" id="job_type" class="regular-text">
                        <option value="">Select Job type</option>
                        <?php
                        if(!empty($jobtypes)){
                            
                            foreach($jobtypes as $type){
                                
                                ?><option value="<?php echo $type->name; ?>" <?php if(isset( $cs_meta_val['job_type'])) { if($cs_meta_val['job_type'][0]== $type->name) { echo 'selected'; } } ?>><?php echo $type->name; ?></option>
                                <?php
                            }
                            
                        }
                        ?>
                       
                        

                    </select>
                    </td>
                   
                </tr>
                <tr>
                    <th><label for="job_location">Job Location</label></th>
                    <td><input type="text" name="job_location" id="job_location" class="regular-text" value="<?php if( isset ( $cs_meta_val['job_location'])) echo $cs_meta_val['job_location'][0] ?>"></td>
                </tr>
                <tr>
                    <th><label for="Benefits">Benefits</label></th>
               
                    <td>
                    <?php 
                    $diwp_custom_editor = get_post_meta($post->ID, 'benefits', true); 
                    wp_editor($diwp_custom_editor, 'benefits', array() ); 
                    ?>
                    </td>
                </tr>

                <tr>
                    <th><label for="Experience">Experience</label></th>
               
                    <td>
                    <?php 
                    $diwp_custom_editor = get_post_meta($post->ID, 'experience', true); 
                    wp_editor($diwp_custom_editor, 'experience', array() ); 
                    ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="job_expiry">Job Expiry</label></th>
                    <td><input type="date" name="job_expiry" id="job_expiry" class="regular-text" value="<?php if( isset ( $cs_meta_val['job_expiry'])) echo $cs_meta_val['job_expiry'][0] ?>"></td>
                </tr>
                 <tr>
                    <th><label for="job_price">Job Price</label></th>
                    <td><input type="text" name="job_price" id="job_price" class="regular-text" value="<?php if( isset ( $cs_meta_val['job_price'])) echo $cs_meta_val['job_price'][0] ?>"></td>
                </tr>
            </table>
            <?php     
        }

         //save meta value with save post hook
        add_action('save_post', 'jobs_save_custom_field_value');
        function jobs_save_custom_field_value( $post_id ){

            // if(isset($_POST['jobformid'])){
            //     update_post_meta($post_id,'jobformid', sanitize_text_field($_POST['jobformid']));
            // } else {
            // delete_post_meta( $post_id, 'job_form_id' );
            // }

            if(isset($_POST['job_id'])){
                update_post_meta($post_id,'job_id', sanitize_text_field($_POST['job_id']));
            } else {
            delete_post_meta( $post_id, 'job_id' );
            }
            
            if(isset($_POST['job_type'])){
                update_post_meta($post_id,'job_type', sanitize_text_field($_POST['job_type']));
            } else {
            delete_post_meta( $post_id, 'job_type' );
            }

            if(isset($_POST['assessment'])){
                update_post_meta($post_id,'assessment', sanitize_text_field($_POST['assessment']));
            } else {
            delete_post_meta( $post_id, 'assessment' );
            }
            
            if(isset($_POST['job_location'])){
                update_post_meta($post_id,'job_location', sanitize_text_field($_POST['job_location']));
            } else {
            delete_post_meta( $post_id, 'job_location' );
            }

            if(isset($_POST['benefits'])){
                update_post_meta($post_id,'benefits', $_POST['benefits']);
            } else {
            delete_post_meta( $post_id, 'benefits' );
            }
            
            if(isset($_POST['experience'])){
                update_post_meta($post_id,'experience', $_POST['experience']);
            } else {
            delete_post_meta( $post_id, 'experience' );
            }
            
            if(isset($_POST['job_expiry'])){
                update_post_meta($post_id,'job_expiry', sanitize_text_field($_POST['job_expiry']));
            } else {
            delete_post_meta( $post_id, 'job_expiry' );
            }
            
            if(isset($_POST['job_price'])){
                update_post_meta($post_id,'job_price', sanitize_text_field($_POST['job_price']));
            } else {
            delete_post_meta( $post_id, 'job_price' );
            }


            
            

        }



         //Meta callback function
        function jobs_custom_form($post){
            $cs_meta_val=get_post_meta($post->ID);
            ?>
            <div id="build-wrap" class="build-wrap form-wrapper-div"></div>
            
            <?php     
        }

        function application_custom_fields_html($post){

            $cs_meta_val=get_post_meta($post->ID);
            $job_opening_id=get_post_meta($post->ID,'job_opening_id',true);
            $mergearray=array();
            $assessment = get_post_meta($job_opening_id,'assessment',true) ? get_post_meta($job_opening_id,'assessment',true):'';
              if($assessment!=''){
                  
                    global $wpdb;
                    $assesment_table = $wpdb->prefix.'job_assesments';
                    $assessments = $wpdb->get_results("SELECT * FROM $assesment_table where id=$assessment");
                    $trait_id=$assessments[0]->traits;
                    if($trait_id!=''){
                        
                        $traits_table = $wpdb->prefix.'job_traits';
                        $trait_data = $wpdb->get_results("SELECT * FROM $traits_table where id=$trait_id");
                        $formdata=$trait_data[0]->form_data;
                        if(is_serialized($formdata))
                        {
                            $formdata=unserialize($formdata);
                            $mergearray=array_merge($mergearray,$formdata);
                        }
                    
                        
                    }
                
                }
            //$job_attributes=get_the_terms($job_opening_id,'job-attributes');
            
            // if(!empty($job_attributes)){
                
            //   $jobattri_ids=array();
              
            //     foreach($job_attributes as $job_attribute){
            //       $jobattri_ids[]=$job_attribute->term_id;
            //     }
              
            //     $jobattri_ids=implode(",",$jobattri_ids);
            //     global $wpdb;
            //     $tablename = $wpdb->prefix.'job_form_data';
            //     $jobforms = $wpdb->get_results("SELECT * FROM $tablename where job_attribute IN ($jobattri_ids)");
            //     if(!empty($jobforms))
            //     {
            //         foreach($jobforms as $jobform)
            //         {
              
            //             $form=$jobform->job_form;
            //             if(is_serialized($form))
            //             {
            //                 $formdata=unserialize($form);
            //                 $mergearray=array_merge($mergearray,$formdata);
            //             }
            //         }
                    
            //     }
            // }
            
                ?>
                <div class="form-table">
                <?php
                $mergearray = array_map("unserialize", array_unique(array_map("serialize", $mergearray)));
                if(FALSE === get_option('main_job_form') && FALSE === update_option('main_job_form',FALSE)) 
                {
                    $main_get_form=array();
                    $mergearray=array_merge($main_get_form,$mergearray);
                   
                }
                else{
                    $main_get_form=get_option('main_job_form');
                    $main_get_form=unserialize($main_get_form);
                    $mergearray=array_merge($main_get_form,$mergearray);
                }
                
                if(get_post_meta($post->ID,'resume_files',true)){
                ?>
                <div class="candidate_custom_button"><a href="<?php echo site_url().'?id='.$post->ID.'&download_pdf=download_pdf'; ?>" target="_blank">Download Files</a></div>
                <?php
                }
                $i=1;
                foreach($mergearray as $form)
                {
                   
                    if($form->type=='text'){
                    $label=isset($form->label) ? $form->label:'';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                      <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    if($form->type=='select'){
                    $label=isset($form->label) ? $form->label:'';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                       <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
    
                    if($form->type=='textarea'){
                         $label=isset($form->label) ? $form->label:'';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                     <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    if($form->type=='number'){
                         $label=isset($form->label) ? $form->label:'';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                      <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    if($form->type=='checkbox-group'){
                         $label=isset($form->label) ? $form->label:'Condition';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                      <div class="candidate_custom_data">
                        <h4><?php echo $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    if($form->type=='date'){
                         $label=isset($form->label) ? $form->label:'';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                      <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    if($form->type=='radio-group'){
                         $label=isset($form->label) ? $form->label:'Condition';
                    $name='name_'.$i;
                    $value=isset($form->name) ? get_post_meta($post->ID,$form->name,true):get_post_meta($post->ID,$name,true);
                      ?>
                     <div class="candidate_custom_data">
                        <h4><?php echo  $label; ?></h4>
                        <h6><?php echo $value; ?></h6>
                      </div>
                      <?php
                    }
                    
                    $i=$i+1;

                }
                if ( metadata_exists( 'post', $post->ID, 'cover_file' ) ) 
                    {
                         $data=get_post_meta($post->ID,'cover_file',true);
                         $resumedata=unserialize($data);
                         if(!empty($resumedata)){
                           ?> 
                           <div class='candidate_custom_data'>
                               <h4 style='margin:0;padding-bottom:5px;'>Cover file</h4>
                               <h6> <div class="cover_download"><a href="<?php echo site_url().'?id='.$post->ID.'&cover_file=cover_file'; ?>" target="_blank">Download File</a></div></h6>
                            </div>
                            <?php
                         }
                    }
                ?>
                <div class="downloadbuttons">
                    <div class="candidate_download"><a href="<?php echo site_url().'?id='.$post->ID.'&download_candidate_data=download_candidate_data'; ?>" target="_blank">Download</a></div>
                <div class="candidate_download"><a href="<?php echo site_url().'?id='.$post->ID.'&print_candidate_data=print_candidate_data'; ?>" target="_blank">Print</a></div>
                </div>
                

                </div>
                <?php
                
        }

       function action_custom_fields_html($post){

        $cs_meta_val=get_post_meta($post->ID);
        $job_status=get_post_meta($post->ID,'job_status',true);
        $candidate_notes=get_post_meta($post->ID,'candidate_notes',true);
        $rating=get_post_meta($post->ID,'rating',true);
        

        ?>
        <table class="my-action-table">
                <tr>
                    <td>
                        <label for="job_type">Status</label>
                        <select name="job_status" id="job_status" class="regular-text">
                        <option value="">Select Status</option>
                        <option value="inprogress" <?php if($job_status) { if($job_status=='inprogress') { echo 'selected'; } }   ?>>In Progress</option>
                        <option value="shortlisted" <?php if($job_status) { if($job_status=='shortlisted') { echo 'selected'; } }   ?>>Shortlisted</option>
                        <option value="rejected" <?php if($job_status) { if($job_status=='rejected') { echo 'selected'; } }   ?>>Rejected</option>
                        <option value="selected" <?php if($job_status) { if($job_status=='selected') { echo 'selected'; } }   ?>>Selected</option>
                        </select>
                    </td>
                   
                    <td>
                        <label for="notes">Notes</label>
                        <input type="text" name="candidate_notes" placeholder="Write your notes here" value="<?php if( isset ( $candidate_notes)) echo $candidate_notes; ?>">
                    </td>
                    
                    <td>
                        <label for="job_type">Rating</label>
                        <div class="rate">
                            
                            
                            <input type="radio" id="star5" name="rating" value="5" <?php if($rating!=''){ echo ($rating == 5) ?'checked="checked"':'';} ?>>
                            <label for="star5"></label>
                            
                            <input type="radio" id="star4" name="rating" value="4" <?php if($rating!=''){ echo ($rating == 4) ?'checked="checked"':'';} ?>>
                            <label for="star4"></label>
                             <input type="radio" id="star3" name="rating" value="3" <?php if($rating!=''){ echo ($rating == 3) ?'checked="checked"':'';} ?>>
                            <label for="star3"></label>
                             <input type="radio" id="star2" name="rating" value="2" <?php if($rating!=''){ echo ($rating == 2) ?'checked="checked"':'';} ?>>
                            <label for="star2"></label>
                            <input type="radio" id="star1" name="rating" value="1" <?php if($rating!=''){ echo ($rating == 1) ?'checked="checked"':'';} ?>>
                            <label for="star1"></label>
                            
                            
                        </div>
                    
                    </td>
                    
                </tr>
        </table>
        <?php
       }

        //save meta value with save post hook
        add_action('save_post', 'application_save_custom_field_value');
        function application_save_custom_field_value( $post_id ){
            
                $current_user = wp_get_current_user();
                $firstname=$current_user->user_login;
                $date = date('M d,Y @ h:i');
                
            
            

            if(isset($_POST['job_status']) && !empty($_POST['job_status']))
            {
                $job_status=get_post_meta($post_id,'job_status',true);
                if($job_status!=$_POST['job_status']){
                    update_post_meta($post_id,'job_status', sanitize_text_field($_POST['job_status']));
                    $message="Application " . sanitize_text_field($_POST['job_status']);
                    if ( metadata_exists( 'post', $post_id, 'activity_log' ) ) 
                    {
                        
                        $activity_log=get_post_meta($post_id, 'activity_log', true);
                        $mainarray=unserialize($activity_log);
                        $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                        array_push($mainarray,$user_view_activity);
                        $activity_log=serialize($mainarray);
                        update_post_meta($post_id, 'activity_log', $activity_log);
                    }
                    else{
                            $mainarray=array();
                            $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                            array_push($mainarray,$user_view_activity);
                            $activity_log=serialize($mainarray);
                            add_post_meta($post_id, 'activity_log', $activity_log);
                    }
                }
            }
            else {
            delete_post_meta( $post_id, 'job_status' );
            }
            
            if(isset($_POST['candidate_notes']) && !empty($_POST['candidate_notes'])){
                update_post_meta($post_id,'candidate_notes', sanitize_text_field($_POST['candidate_notes']));
                $message="Application Notes-" . sanitize_text_field($_POST['candidate_notes']);
                if ( metadata_exists( 'post', $post_id, 'activity_log' ) ) 
                {
                    
                    $activity_log=get_post_meta($post_id, 'activity_log', true);
                    $mainarray=unserialize($activity_log);
                    $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                    array_push($mainarray,$user_view_activity);
                    $activity_log=serialize($mainarray);
                    update_post_meta($post_id, 'activity_log', $activity_log);
                }
                else{
                        $mainarray=array();
                        $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                        array_push($mainarray,$user_view_activity);
                        $activity_log=serialize($mainarray);
                        add_post_meta($post_id, 'activity_log', $activity_log);
                }
               
            } else {
            delete_post_meta( $post_id, 'candidate_notes' );
            }
            
            if(isset($_POST['rating']) && !empty($_POST['rating'])){
               $current_rating=get_post_meta($post_id,'rating',true);
               if($current_rating != $_POST['rating']){
                    $rating=$_POST['rating'];
                    //$rating=$ratings[0];
                    update_post_meta($post_id,'rating',$rating);
                    $message="Application - " . $rating."-star rated";
                    if ( metadata_exists( 'post', $post_id, 'activity_log' ) ) 
                    {
                        
                        $activity_log=get_post_meta($post_id, 'activity_log', true);
                        $mainarray=unserialize($activity_log);
                        $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                        array_push($mainarray,$user_view_activity);
                        $activity_log=serialize($mainarray);
                        update_post_meta($post_id, 'activity_log', $activity_log);
                    }
                    else{
                            $mainarray=array();
                            $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                            array_push($mainarray,$user_view_activity);
                            $activity_log=serialize($mainarray);
                            add_post_meta($post_id, 'activity_log', $activity_log);
                    }
               }
            } else {
            delete_post_meta( $post_id, 'rating' );
            }
            

        }
        
        function activity_custom_fields_html($post){
        
        $current_user = wp_get_current_user();
        $firstname=$current_user->user_login;
        $date = date('M d,Y @ h:i');
        $postid =$post->ID;
        /*
        if ( metadata_exists( 'post', $postid, 'activity_log' ) ) 
        {
            
            $activity_log=get_post_meta($postid, 'activity_log', true);
            $mainarray=unserialize($activity_log);
            $user_view_activity=array("message"=>'Application Viewed',"username"=>$firstname,"date"=>$date);
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
        */
        $data=get_post_meta($postid, 'activity_log', true);
        $data=unserialize($data);
        //print_r($data);
        function setPostViews($postID) {
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    
        setPostViews($postid);
    
        //echo $postcount=get_post_meta($postid, 'post_views_count', true);
        
        $cs_meta_val=get_post_meta($post->ID);
        $activity_log=get_post_meta($post->ID,'activity_log',true);
        $logs=unserialize($activity_log);
       

        ?>
        <ul class="activity_logs">
            <?php
            if(isset($logs) && !empty($logs)){
                
                            
                foreach(array_reverse($logs) as $log){
                    
                   
                     ?><li><span class="log_message"><?php echo $log['message'] ?></span><span class="username"><?php echo $log['username'] ?></span><span class="date"><?php echo $log['date'] ?></span></li><?php
                    
                    
                 }
                
            }
            ?>
        </ul>
        <?php
       }
       
    //   add_action('add_meta_boxes',function (){
    //       add_meta_box( 'awsm-application-mail-meta',esc_html__( 'Emails', 'job-openings' ),array( $this, 'awsm_job_application_email_handler' ), 'jobs-application', 'normal', 'low' );

    //     });
    

   }
    
    public function awsm_job_application_email_handler( $post ) {
        
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/templates/meta/application-email.php';
       
       // include($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/job-openings/admin/templates/meta/application-email.php");
      
	}


    public function awsm_job_status( $post ) {
        
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/templates/meta/job-status.php';
       // echo $_SERVER['DOCUMENT_ROOT'];
    //include($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/job-openings/admin/templates/meta/job-status.php");
      // include(plugin_dir_url(__DIR__). 'admin/templates/meta/job-status.php');
     //include  plugin_dir_url(__DIR__). 'job/templates/meta/job-status.php';
		//include $this->cpath . '/templates/meta/job-status.php';
	}
	
	    public function applicant_mail_template( $data = array() ) {
			$template_data = wp_parse_args(
				$data,
				array(
					'author'    => '{{data.author}}',
					'date_i18n' => '{{data.date_i18n}}',
					'subject'   => '{{data.subject}}',
					'content'   => '{{{data.content}}}',
				)
			);
			?>
			<div class="awsm-jobs-applicant-mail">
				<div class="awsm-jobs-applicant-mail-header">
					<h3><?php echo esc_html( $template_data['subject'] ); ?></h3>
					<p class="awsm-jobs-applicant-mail-meta">
						<span><?php echo esc_html( $template_data['author'] ); ?></span>
						<span><?php echo esc_html( $template_data['date_i18n'] ); ?></span>
					</p>
				</div>
				<div class="awsm-jobs-applicant-mail-content">
					<?php
						echo wp_kses(
							$template_data['content'],
							array(
								'p'  => array(),
								'br' => array(),
							)
						);
					?>
				</div>
			</div>
			<?php
		}
		public function get_username( $user_id, $user_data = null ) {
			$user_info = empty( $user_data ) ? get_userdata( $user_id ) : $user_data;
			$user      = $user_info->display_name;
			if ( empty( $user ) ) {
				$user = $user_info->user_login;
			}
			return $user;
		}

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }

    public function get_loader() {
        return $this->loader;
    }
    
   

   

}