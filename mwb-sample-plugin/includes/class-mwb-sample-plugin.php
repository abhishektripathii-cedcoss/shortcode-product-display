<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/includes
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
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_sample_plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mwb_sample_plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		if ( defined( 'MWB_SAMPLE_PLUGIN_VERSION' ) ) {

			$this->version = MWB_SAMPLE_PLUGIN_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'mwb-sample-plugin';

		$this->mwb_sample_plugin_dependencies();
		$this->mwb_sample_plugin_locale();
		$this->mwb_sample_plugin_admin_hooks();
		$this->mwb_sample_plugin_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_sample_plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_sample_plugin_i18n. Defines internationalization functionality.
	 * - Mwb_sample_plugin_Admin. Defines all hooks for the admin area.
	 * - Mwb_sample_plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_sample_plugin_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-sample-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-sample-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-sample-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwb-sample-plugin-public.php';

		$this->loader = new Mwb_sample_plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_sample_plugin_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_sample_plugin_locale() {

		$plugin_i18n = new Mwb_sample_plugin_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_sample_plugin_admin_hooks() {

		$msp_plugin_admin = new Mwb_sample_plugin_Admin( $this->msp_get_plugin_name(), $this->msp_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $msp_plugin_admin, 'msp_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $msp_plugin_admin, 'msp_admin_enqueue_scripts' );

		// Add settings menu for mwb-sample-plugin.
		$this->loader->add_action( 'admin_menu', $msp_plugin_admin, 'msp_options_page' );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $msp_plugin_admin, 'msp_admin_submenu_page', 15 );
		$this->loader->add_filter( 'msp_general_settings_array', $msp_plugin_admin, 'msp_admin_general_settings_page', 10 );

		// Admin action for custom_post_types self.
		$this->loader->add_action( 'init', $msp_plugin_admin, 'mwb_custom_post_type_products', 99 );
		// Admin action for custom_taxonomy_types self.
		$this->loader->add_action( 'init', $msp_plugin_admin, 'mwb_register_taxonomy_procategories', 100 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_sample_plugin_public_hooks() {

		$msp_plugin_public = new Mwb_sample_plugin_Public( $this->msp_get_plugin_name(), $this->msp_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $msp_plugin_public, 'msp_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $msp_plugin_public, 'msp_public_enqueue_scripts' );
		// Add action for SHORTCODE self.
		$this->loader->add_action( 'init', $msp_plugin_public, 'msp_public_shortcode' );
		// Add action for TEMPLATE INCLUDE self.
		$this->loader->add_filter( 'template_include', $msp_plugin_public, 'msp_public_template_function' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function msp_run() {
		$this->loader->msp_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function msp_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mwb_sample_plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function msp_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function msp_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_msp_plug tabs.
	 *
	 * @return  Array       An key=>value pair of mwb-sample-plugin tabs.
	 */
	public function mwb_msp_plug_default_tabs() {

		$msp_default_tabs = array();

		$msp_default_tabs['mwb-sample-plugin-general'] = array(
			'title'       => esc_html__( 'General Setting', 'mwb-sample-plugin' ),
			'name'        => 'mwb-sample-plugin-general',
		);
		$msp_default_tabs = apply_filters( 'mwb_msp_plugin_standard_admin_settings_tabs', $msp_default_tabs );

		$msp_default_tabs['mwb-sample-plugin-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'mwb-sample-plugin' ),
			'name'        => 'mwb-sample-plugin-system-status',
		);

		return $msp_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_msp_plug_load_template( $path, $params = array() ) {

		$msp_file_path = MWB_SAMPLE_PLUGIN_DIR_PATH . $path;

		if ( file_exists( $msp_file_path ) ) {

			include $msp_file_path;
		} else {

			/* translators: %s: file path */
			$msp_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'mwb-sample-plugin' ), $msp_file_path );
			$this->mwb_msp_plug_admin_notice( $msp_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $msp_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_msp_plug_admin_notice( $msp_message, $type = 'error' ) {

		$msp_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$msp_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$msp_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$msp_classes .= 'notice-success is-dismissible';
				break;

			default:
				$msp_classes .= 'notice-error is-dismissible';
		}

		$msp_notice  = '<div class="' . esc_attr( $msp_classes ) . '">';
		$msp_notice .= '<p>' . esc_html( $msp_message ) . '</p>';
		$msp_notice .= '</div>';

		echo wp_kses_post( $msp_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $msp_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_msp_plug_system_status() {
		global $wpdb;
		$msp_system_status = array();
		$msp_wordpress_status = array();
		$msp_system_data = array();

		// Get the web server.
		$msp_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$msp_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'mwb-sample-plugin' );

		// Get the server's IP address.
		$msp_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$msp_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$msp_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'mwb-sample-plugin' );

		// Get the server path.
		$msp_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'mwb-sample-plugin' );

		// Get the OS.
		$msp_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'mwb-sample-plugin' );

		// Get WordPress version.
		$msp_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'mwb-sample-plugin' );

		// Get and count active WordPress plugins.
		$msp_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'mwb-sample-plugin' );

		// See if this site is multisite or not.
		$msp_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'mwb-sample-plugin' ) : __( 'No', 'mwb-sample-plugin' );

		// See if WP Debug is enabled.
		$msp_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'mwb-sample-plugin' ) : __( 'No', 'mwb-sample-plugin' );

		// See if WP Cache is enabled.
		$msp_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'mwb-sample-plugin' ) : __( 'No', 'mwb-sample-plugin' );

		// Get the total number of WordPress users on the site.
		$msp_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'mwb-sample-plugin' );

		// Get the number of published WordPress posts.
		$msp_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'mwb-sample-plugin' );

		// Get PHP memory limit.
		$msp_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-sample-plugin' );

		// Get the PHP error log path.
		$msp_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'mwb-sample-plugin' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$msp_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'mwb-sample-plugin' );

		// Get PHP max post size.
		$msp_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'mwb-sample-plugin' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$msp_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$msp_system_status['php_architecture'] = '64-bit';
		} else {
			$msp_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$msp_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'mwb-sample-plugin' );

		// Show the number of processes currently running on the server.
		$msp_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'mwb-sample-plugin' );

		// Get the memory usage.
		$msp_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$msp_system_status['is_windows'] = true;
			$msp_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'mwb-sample-plugin' );
		}

		// Get the memory limit.
		$msp_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-sample-plugin' );

		// Get the PHP maximum execution time.
		$msp_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'mwb-sample-plugin' );

		// Get outgoing IP address.
		$msp_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'mwb-sample-plugin' );

		$msp_system_data['php'] = $msp_system_status;
		$msp_system_data['wp'] = $msp_wordpress_status;

		return $msp_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $msp_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_msp_plug_generate_html( $msp_components = array() ) {
		if ( is_array( $msp_components ) && ! empty( $msp_components ) ) {
			foreach ( $msp_components as $msp_component ) {
				switch ( $msp_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'password':
					case 'email':
					case 'text':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $msp_component['id'] ); ?>"><?php echo esc_html( $msp_component['title'] ); // WPCS: XSS ok. ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $msp_component['type'] ) ); ?>">
								<input
								name="<?php echo esc_attr( $msp_component['id'] ); ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								type="<?php echo esc_attr( $msp_component['type'] ); ?>"
								value="<?php echo esc_attr( $msp_component['value'] ); ?>"
								class="<?php echo esc_attr( $msp_component['class'] ); ?>"
								placeholder="<?php echo esc_attr( $msp_component['placeholder'] ); ?>"
								/>
								<p class="msp-descp-tip"><?php echo esc_html( $msp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'textarea':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $msp_component['id'] ); ?>"><?php echo esc_html( $msp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $msp_component['type'] ) ); ?>">
								<textarea
								name="<?php echo esc_attr( $msp_component['id'] ); ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								class="<?php echo esc_attr( $msp_component['class'] ); ?>"
								rows="<?php echo esc_attr( $msp_component['rows'] ); ?>"
								cols="<?php echo esc_attr( $msp_component['cols'] ); ?>"
								placeholder="<?php echo esc_attr( $msp_component['placeholder'] ); ?>"
								><?php echo esc_textarea( $msp_component['value'] ); // WPCS: XSS ok. ?></textarea>
								<p class="msp-descp-tip"><?php echo esc_html( $msp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $msp_component['id'] ); ?>"><?php echo esc_html( $msp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $msp_component['type'] ) ); ?>">
								<select
								name="<?php echo esc_attr( $msp_component['id'] ); ?><?php echo ( 'multiselect' === $msp_component['type'] ) ? '[]' : ''; ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								class="<?php echo esc_attr( $msp_component['class'] ); ?>"
								<?php echo 'multiselect' === $msp_component['type'] ? 'multiple="multiple"' : ''; ?>
								>
								<?php
								foreach ( $msp_component['options'] as $msp_key => $msp_val ) {
									?>
									<option value="<?php echo esc_attr( $msp_key ); ?>"
										<?php
										if ( is_array( $msp_component['value'] ) ) {
											selected( in_array( (string) $msp_key, $msp_component['value'], true ), true );
										} else {
											selected( $msp_component['value'], (string) $msp_key );
										}
										?>
										>
										<?php echo esc_html( $msp_val ); ?>
									</option>
									<?php
								}
								?>
								</select> 
								<p class="msp-descp-tip"><?php echo esc_html( $msp_component['description'] ); // WPCS: XSS ok. ?></p>
							</td>
						</tr>
						<?php
						break;

					case 'checkbox':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc"><?php echo esc_html( $msp_component['title'] ); ?></th>
							<td class="forminp forminp-checkbox">
								<label for="<?php echo esc_attr( $msp_component['id'] ); ?>"></label>
								<input
								name="<?php echo esc_attr( $msp_component['id'] ); ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								type="checkbox"
								class="<?php echo esc_attr( isset( $msp_component['class'] ) ? $msp_component['class'] : '' ); ?>"
								value="1"
								<?php checked( $msp_component['value'], '1' ); ?>
								/> 
								<span class="msp-descp-tip"><?php echo esc_html( $msp_component['description'] ); // WPCS: XSS ok. ?></span>

							</td>
						</tr>
						<?php
						break;

					case 'radio':
						?>
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $msp_component['id'] ); ?>"><?php echo esc_html( $msp_component['title'] ); ?>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $msp_component['type'] ) ); ?>">
								<fieldset>
									<span class="msp-descp-tip"><?php echo esc_html( $msp_component['description'] ); // WPCS: XSS ok. ?></span>
									<ul>
										<?php
										foreach ( $msp_component['options'] as $msp_radio_key => $msp_radio_val ) {
											?>
											<li>
												<label><input
													name="<?php echo esc_attr( $msp_component['id'] ); ?>"
													value="<?php echo esc_attr( $msp_radio_key ); ?>"
													type="radio"
													class="<?php echo esc_attr( $msp_component['class'] ); ?>"
												<?php checked( $msp_radio_key, $msp_component['value'] ); ?>
													/> <?php echo esc_html( $msp_radio_val ); ?></label>
											</li>
											<?php
										}
										?>
									</ul>
								</fieldset>
							</td>
						</tr>
						<?php
						break;

					case 'button':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="button" class="button button-primary" 
								name="<?php echo esc_attr( $msp_component['id'] ); ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								value="<?php echo esc_attr( $msp_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					case 'submit':
						?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo esc_attr( $msp_component['id'] ); ?>"
								id="<?php echo esc_attr( $msp_component['id'] ); ?>"
								value="<?php echo esc_attr( $msp_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
