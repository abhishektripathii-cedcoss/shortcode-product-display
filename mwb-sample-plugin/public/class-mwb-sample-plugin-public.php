<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace mwb_sample_plugin_public.
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_sample_plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msp_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, MWB_SAMPLE_PLUGIN_DIR_URL . 'public/css/mwb-sample-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function msp_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, MWB_SAMPLE_PLUGIN_DIR_URL . 'public/js/mwb-sample-plugin-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'msp_public_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name );

	}
	/**
	 * Register the shortcode self.
	 *
	 * @since    1.0.0
	 */
	public function msp_public_shortcode() {
		// New second parameterised shortcode.
		add_shortcode( 'products', 'mwb_shortcode_param_function' );

		/**
		 * Shortcode callback function with parameter.
		 */
		function mwb_shortcode_param_function( $atts = array() ) {
			$category = $atts['cat'];
			$show     = $atts['show'];
			$args = array(
				'post_type'      => 'mwb_products',
				'posts_per_page' => $show,
				'tax_query'  => array(
					'taxonomy' => 'product-category',
					'field'    => 'slug',
					'terms'    => $category,
				)
			);

			$loop = new WP_Query( $args );

			if ( $loop->have_posts() ) {
				$content = '';
				while ( $loop->have_posts() ) {
					$loop->the_post();
					$content .= the_title();
					$content .= the_content();
					$content .= the_post_thumbnail();

				}
			}
			return $content;
		}

	}
	/**
	 * Register the template include function self.
	 *
	 * @since    1.0.0
	 */
	public function msp_public_template_function( $page_template ){
		if ( is_page( 'SHOP' ) ) {
			$page_template = MWB_SAMPLE_PLUGIN_DIR_PATH . 'public/partials/template/custom-page.php';
		}
		return $page_template;
	}
}
