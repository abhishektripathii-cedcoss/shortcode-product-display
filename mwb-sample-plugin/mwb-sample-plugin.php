<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Mwb_sample_plugin
 *
 * @wordpress-plugin
 * Plugin Name:       mwb-sample-plugin
 * Plugin URI:        https://makewebbetter.com/product/mwb-sample-plugin/
 * Description:       Your Basic Plugin
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       mwb-sample-plugin
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_mwb_sample_plugin_constants() {

	mwb_sample_plugin_constants( 'MWB_SAMPLE_PLUGIN_VERSION', '1.0.0' );
	mwb_sample_plugin_constants( 'MWB_SAMPLE_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
	mwb_sample_plugin_constants( 'MWB_SAMPLE_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
	mwb_sample_plugin_constants( 'MWB_SAMPLE_PLUGIN_SERVER_URL', 'https://makewebbetter.com' );
	mwb_sample_plugin_constants( 'MWB_SAMPLE_PLUGIN_ITEM_REFERENCE', 'mwb-sample-plugin' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function mwb_sample_plugin_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwb-sample-plugin-activator.php
 */
function activate_mwb_sample_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-sample-plugin-activator.php';
	Mwb_sample_plugin_Activator::mwb_sample_plugin_activate();
	$mwb_msp_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_msp_active_plugin ) && ! empty( $mwb_msp_active_plugin ) ) {
		$mwb_msp_active_plugin['mwb-sample-plugin'] = array(
			'plugin_name' => __( 'mwb-sample-plugin', 'mwb-sample-plugin' ),
			'active' => '1',
		);
	} else {
		$mwb_msp_active_plugin = array();
		$mwb_msp_active_plugin['mwb-sample-plugin'] = array(
			'plugin_name' => __( 'mwb-sample-plugin', 'mwb-sample-plugin' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_msp_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwb-sample-plugin-deactivator.php
 */
function deactivate_mwb_sample_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-sample-plugin-deactivator.php';
	Mwb_sample_plugin_Deactivator::mwb_sample_plugin_deactivate();
	$mwb_msp_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_msp_deactive_plugin ) && ! empty( $mwb_msp_deactive_plugin ) ) {
		foreach ( $mwb_msp_deactive_plugin as $mwb_msp_deactive_key => $mwb_msp_deactive ) {
			if ( 'mwb-sample-plugin' === $mwb_msp_deactive_key ) {
				$mwb_msp_deactive_plugin[ $mwb_msp_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_msp_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_mwb_sample_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_mwb_sample_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-sample-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mwb_sample_plugin() {
	define_mwb_sample_plugin_constants();

	$msp_plugin_standard = new Mwb_sample_plugin();
	$msp_plugin_standard->msp_run();
	$GLOBALS['msp_mwb_msp_obj'] = $msp_plugin_standard;

}
run_mwb_sample_plugin();

// Add rest api endpoint for plugin.
add_action( 'rest_api_init', 'msp_add_default_endpoint' );

/**
 * Callback function for endpoints.
 *
 * @since    1.0.0
 */
function msp_add_default_endpoint() {
	register_rest_route(
		'msp-route',
		'/msp-dummy-data/',
		array(
			'methods'  => 'POST',
			'callback' => 'mwb_msp_default_callback',
			'permission_callback' => 'mwb_msp_default_permission_check',
		)
	);
}

/**
 * API validation
 * @param 	Array 	$request 	All information related with the api request containing in this array.
 * @since    1.0.0
 */
function mwb_msp_default_permission_check($request) {

	// Add rest api validation for each request.
	$result = true;
	return $result;
}

/**
 * Begins execution of api endpoint.
 *
 * @param   Array $request    All information related with the api request containing in this array.
 * @return  Array   $mwb_msp_response   return rest response to server from where the endpoint hits.
 * @since    1.0.0
 */
function mwb_msp_default_callback( $request ) {
	require_once MWB_SAMPLE_PLUGIN_DIR_PATH . 'includes/class-mwb-sample-plugin-api-process.php';
	$mwb_msp_api_obj = new Mwb_sample_plugin_Api_Process();
	$mwb_msp_resultsdata = $mwb_msp_api_obj->mwb_msp_default_process( $request );
	if ( is_array( $mwb_msp_resultsdata ) && isset( $mwb_msp_resultsdata['status'] ) && 200 == $mwb_msp_resultsdata['status'] ) {
		unset( $mwb_msp_resultsdata['status'] );
		$mwb_msp_response = new WP_REST_Response( $mwb_msp_resultsdata, 200 );
	} else {
		$mwb_msp_response = new WP_Error( $mwb_msp_resultsdata );
	}
	return $mwb_msp_response;
}


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_sample_plugin_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function mwb_sample_plugin_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=mwb_sample_plugin_menu' ) . '">' . __( 'Settings', 'mwb-sample-plugin' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
