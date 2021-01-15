<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_sample_plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function mwb_sample_plugin_activate() {
		// Create post object.
		$my_post = array(
			'post_title'   => 'SHOP',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'page',
		);

		// Insert the post into the database.
		wp_insert_post( $my_post );

	}

}
