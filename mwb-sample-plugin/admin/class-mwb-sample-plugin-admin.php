<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_sample_plugin_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function msp_admin_enqueue_styles( $hook ) {

		wp_enqueue_style( 'mwb-msp-select2-css', MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/css/mwb-sample-plugin-select2.css', array(), time(), 'all' );

		wp_enqueue_style( $this->plugin_name, MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/css/mwb-sample-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function msp_admin_enqueue_scripts( $hook ) {

		wp_enqueue_script( 'mwb-msp-select2', MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/js/mwb-sample-plugin-select2.js', array( 'jquery' ), time(), false );

		wp_register_script( $this->plugin_name . 'admin-js', MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/js/mwb-sample-plugin-admin.js', array( 'jquery', 'mwb-msp-select2' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'msp_admin_param',
			array(
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'reloadurl' => admin_url( 'admin.php?page=mwb_sample_plugin_menu' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'admin-js' );
	}

	/**
	 * Adding settings menu for mwb-sample-plugin.
	 *
	 * @since    1.0.0
	 */
	public function msp_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'mwb-sample-plugin' ), __( 'MakeWebBetter', 'mwb-sample-plugin' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/images/mwb-logo.png', 15 );
			$msp_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $msp_menus ) && ! empty( $msp_menus ) ) {
				foreach ( $msp_menus as $msp_key => $msp_value ) {
					add_submenu_page( 'mwb-plugins', $msp_value['name'], $msp_value['name'], 'manage_options', $msp_value['menu_link'], array( $msp_value['instance'], $msp_value['function'] ) );
				}
			}
		}
	}


	/**
	 * mwb-sample-plugin msp_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function msp_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'mwb-sample-plugin', 'mwb-sample-plugin' ),
			'slug'      => 'mwb_sample_plugin_menu',
			'menu_link' => 'mwb_sample_plugin_menu',
			'instance'  => $this,
			'function'  => 'msp_options_menu_html',
		);
		return $menus;
	}


	/**
	 * mwb-sample-plugin mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require MWB_SAMPLE_PLUGIN_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * mwb-sample-plugin admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function msp_options_menu_html() {

		include_once MWB_SAMPLE_PLUGIN_DIR_PATH . 'admin/partials/mwb-sample-plugin-admin-display.php';
	}

	/**
	 * mwb-sample-plugin admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $msp_settings_general Settings fields.
	 */
	public function msp_admin_general_settings_page( $msp_settings_general ) {
		$msp_settings_general = array(
			array(
				'title'       => __( 'Text Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'text',
				'description' => __( 'This is text field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_text_demo',
				'value'       => '',
				'class'       => 'msp-text-class',
				'placeholder' => __( 'Text Demo', 'mwb-sample-plugin' ),
			),
			array(
				'title'       => __( 'Number Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'number',
				'description' => __( 'This is number field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_number_demo',
				'value'       => '',
				'class'       => 'msp-number-class',
				'placeholder' => '',
			),
			array(
				'title'       => __( 'Password Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'password',
				'description' => __( 'This is password field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_password_demo',
				'value'       => '',
				'class'       => 'msp-password-class',
				'placeholder' => '',
			),
			array(
				'title'       => __( 'Textarea Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'textarea',
				'description' => __( 'This is textarea field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_textarea_demo',
				'value'       => '',
				'class'       => 'msp-textarea-class',
				'rows'        => '5',
				'cols'        => '10',
				'placeholder' => __( 'Textarea Demo', 'mwb-sample-plugin' ),
			),
			array(
				'title'       => __( 'Select Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'select',
				'description' => __( 'This is select field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_select_demo',
				'value'       => '',
				'class'       => 'msp-select-class',
				'placeholder' => __( 'Select Demo', 'mwb-sample-plugin' ),
				'options'     => array(
					'INR' => __( 'Rs.', 'mwb-sample-plugin' ),
					'USD' => __( '$', 'mwb-sample-plugin' ),
				),
			),
			array(
				'title'       => __( 'Multiselect Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'multiselect',
				'description' => __( 'This is multiselect field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_multiselect_demo',
				'value'       => '',
				'class'       => 'msp-multiselect-class mwb-defaut-multiselect',
				'placeholder' => __( 'Multiselect Demo', 'mwb-sample-plugin' ),
				'options'     => array(
					'INR' => __( 'Rs.', 'mwb-sample-plugin' ),
					'USD' => __( '$', 'mwb-sample-plugin' ),
				),
			),
			array(
				'title'       => __( 'Checkbox Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'checkbox',
				'description' => __( 'This is checkbox field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_checkbox_demo',
				'value'       => '',
				'class'       => 'msp-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'mwb-sample-plugin' ),
			),

			array(
				'title'       => __( 'Radio Field Demo', 'mwb-sample-plugin' ),
				'type'        => 'radio',
				'description' => __( 'This is radio field demo follow same structure for further use.', 'mwb-sample-plugin' ),
				'id'          => 'msp_radio_demo',
				'value'       => '',
				'class'       => 'msp-radio-class',
				'placeholder' => __( 'Radio Demo', 'mwb-sample-plugin' ),
				'options'     => array(
					'yes' => __( 'YES', 'mwb-sample-plugin' ),
					'no'  => __( 'NO', 'mwb-sample-plugin' ),
				),
			),

			array(
				'type'        => 'button',
				'id'          => 'msp_button_demo',
				'button_text' => __( 'Button Demo', 'mwb-sample-plugin' ),
				'class'       => 'msp-button-class',
			),
		);
		return $msp_settings_general;
	}
	/**
	 * Registering Custom Post type function for Products
	 *
	 * @return void
	 */
	function mwb_custom_post_type_products() {
		register_post_type(
			'mwb_products',
			array(
				'labels'      => array(
					'name'          => __( 'Products', 'mwb-sample-plugin' ),
					'singular_name' => __( 'Product', 'mwb-sample-plugin' ),
					'add_new'       => __( 'Add New Products', 'mwb-sample-plugin' ),
					'add_new_item'  => __( 'Add New Product', 'mwb-sample-plugin' ),
				),
				'public'      => true,
				'has_archive' => true,
				'supports'    => array(
					'thumbnail',
					'title',
					'editor',
				),
			)
		);
	}
	/**
	 * Register custom taxonomy product function
	 *
	 * @return void
	 */
	function mwb_register_taxonomy_procategories() {
		$labels = array(
			'name'              => _x( 'Pro-categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Pro-category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Pro-categories' ),
			'all_items'         => __( 'All Pro-categories' ),
			'parent_item'       => __( 'Parent Product-category' ),
			'parent_item_colon' => __( 'Parent Product-category:' ),
			'edit_item'         => __( 'Edit Product-category' ),
			'update_item'       => __( 'Update Product-category' ),
			'add_new_item'      => __( 'Add New Product-category' ),
			'new_item_name'     => __( 'New Product-category Name' ),
			'menu_name'         => __( 'Pro-categories' ),
		);
		$args   = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'show_in_api'      => true,
			'rewrite'           => [ 'slug' => 'product-category' ],
		);
		register_taxonomy( 'product-category', 'mwb_products', $args );
	}
}
