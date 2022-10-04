<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.aarvkininfotech.com
 * @since      1.0.0
 *
 * @package    Jobs
 * @subpackage Jobs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Jobs
 * @subpackage Jobs/includes
 * @author     Aarvikinfotech <info@aarvikinfotech>
 */
class Jobs_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {

        $upload = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $upload_dir = $upload_dir . '/jobs';
        if (! is_dir($upload_dir)) {
            mkdir( $upload_dir, 0700 );
        }

         $page_definitions = array(
             
            'apply' => array(
                 'title' => __('Apply'),
                 'content' => ''
             ),
             'job-detail' => array(
                 'title' => __('Job Detail'),
                 'content' => ''
             ),
             'job-openings' => array(
                'title' => __('Jobs'),
                'content' => '[job-listing]'
            )
        );

         foreach ($page_definitions as $slug => $page) {

             // Check that the page doesn't exist already
             $query = new WP_Query('pagename=' . $slug);
            if (!$query->have_posts()) {
                // Add the page using the data from the array above
                 wp_insert_post(
                         array(
                            'post_content' => $page['content'],
                            'post_name' => $slug,
                            'post_title' => $page['title'],
                            'post_status' => 'publish',
                            'post_type' => 'page',
                            'ping_status' => 'closed',
                            'comment_status' => 'closed',
                         )
                 );
             }
         }
		
		
    }

    public static function job_form_data(){

          global $wpdb; 
          $job_form_data = '1.0.0';
          $db_table_name = $wpdb->prefix . 'job_form_data';  // table name
          $charset_collate = $wpdb->get_charset_collate();

         //Check to see if the table exists already, if not, then create it
         if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
         {
               $sql = "CREATE TABLE `$db_table_name` (
                        `id` int(11) NOT NULL auto_increment,
                        `name` varchar(255) NULL,
                        `status` varchar(60) NULL,
                        `job_form` text NULL,
                        `job_attribute` varchar(200) NULL,
                        PRIMARY KEY id (id)
                ) $charset_collate;";

           require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
           dbDelta( $sql );
          add_option( 'job_form_data', $job_form_data );
         }
    }
    
    public static function job_types_data(){
        
        global $wpdb; 
        $job_type_data = '1.0.0';
        $db_table_name = $wpdb->prefix . 'job_types';  // table name
        $charset_collate = $wpdb->get_charset_collate();
    
         //Check to see if the table exists already, if not, then create it
         if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
         {
               $sql = "CREATE TABLE `$db_table_name` (
                        `id` int(11) NOT NULL auto_increment,
                        `name` varchar(255) NULL,
                        PRIMARY KEY id (id)
                ) $charset_collate;";
    
           require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
           dbDelta( $sql );
           add_option( 'job_type_data', $job_type_data );
         }
        
        
    }
    public static function job_assesments_data(){
        
        
        global $wpdb; 
        $job_assesments_data = '1.0.0';
        $db_table_name = $wpdb->prefix . 'job_assesments';  // table name
        $charset_collate = $wpdb->get_charset_collate();
    
        //Check to see if the table exists already, if not, then create it
        
        if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
        {
               $sql = "CREATE TABLE `$db_table_name` (
                        `id` int(11) NOT NULL auto_increment,
                        `name` varchar(255) NULL,
                        `type` varchar(255) NULL,
                        `traits` varchar(255) NULL,
                        PRIMARY KEY id (id)
                ) $charset_collate;";
    
           require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
           dbDelta( $sql );
           add_option( 'job_assesments', $job_assesments_data );
        }
           
    }
    
    public static function job_traits_data(){
        
        global $wpdb; 
        $job_traits_data = '1.0.0';
        $db_table_name = $wpdb->prefix . 'job_traits';  // table name
        $charset_collate = $wpdb->get_charset_collate();
        
        //Check to see if the table exists already, if not, then create it
        
        if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
        {
               $sql = "CREATE TABLE `$db_table_name` (
                        `id` int(11) NOT NULL auto_increment,
                        `traits` varchar(255) NULL,
                        `form_data` text NULL,
                        PRIMARY KEY id (id)
                ) $charset_collate;";
    
           require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
           dbDelta( $sql );
           add_option( 'job_traits_data', $job_traits_data );
        }
        
        
        
    }
	public function create_jobs_directory() {
 
		
	}
	

}
