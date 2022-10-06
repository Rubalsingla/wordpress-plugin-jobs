<?php

/*

Plugin Name: Job Openings

Plugin URI: https://leftfield.net.au/

Description: Plugin is showing Job openings.

Version: 1.0

Author: Aarvik Infotech

Author URI: https://leftfield.net.au/

License: Aarvik

Text Domain: Jobs

*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
    
}

/**
 * The code that runs during plugin activation.

 */
function activate_jobs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jobs-activator.php';
	Jobs_Activator::activate();
    Jobs_Activator::job_form_data();
    Jobs_Activator::job_types_data();
    Jobs_Activator::job_assesments_data();
    Jobs_Activator::job_traits_data();
}

/**
 * The code that runs during plugin deactivation.

 */
function deactivate_jobs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jobs-deactivator.php';
	Jobs_Deactivator::deactivate();
	
}

register_activation_hook( __FILE__, 'activate_jobs' );
register_deactivation_hook( __FILE__, 'deactivate_jobs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jobs.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jobs() {
	
	$plugin = new Job();
	$plugin->run();

}
run_jobs();
