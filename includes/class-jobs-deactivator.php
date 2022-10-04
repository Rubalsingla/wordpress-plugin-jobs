<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.aarvkininfotech.com
 * @since      1.0.0
 *
 * @package    Jobs
 * @subpackage Jobs/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Jobs
 * @subpackage Jobs/includes
 * @author     Aarvikinfotech <info@aarvikinfotech>
 */
class Jobs_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {

         $page_definitions = array(
             'apply' => array(
                 'title' => __('Apply'),
             ),
             'job-detail' => array(
                 'title' => __('Job Detail'),
             ),
             'job-openings' => array(
                 'title' => __('Jobs'),
             ),
             
             
         );

         foreach ($page_definitions as $slug => $page) {
             global $wpdb;
             $table_name=$wpdb->prefix.'posts';
            
             $result = $wpdb->get_row("SELECT * FROM $table_name WHERE post_name= '$slug'");
             $the_page_id = $result->ID; //exit;
             //echo $the_page_id;
            //die('sfg');
             if ($the_page_id) {
                
                 wp_delete_post($the_page_id, true); // this will permanently delete pages which are create by plugin
             }
        }
       
		
    }
	
	
}


        