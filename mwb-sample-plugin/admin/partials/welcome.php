<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the welcome html.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-msp-main-wrapper">
	<div class="mwb-msp-go-pro">
		<div class="mwb-msp-go-pro-banner">
			<div class="mwb-msp-inner-container">
				<div class="mwb-msp-name-wrapper" id="mwb-msp-page-header">
					<h3><?php esc_html_e( 'Welcome To MakeWebBetter', 'mwb-sample-plugin' ); ?></h4>
					</div>
				</div>
			</div>
			<div class="mwb-msp-inner-logo-container">
				<div class="mwb-msp-main-logo">
					<img src="<?php echo esc_url( MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/images/logo.png' ); ?>">
					<h2><?php esc_html_e( 'We make the customer experience better', 'mwb-sample-plugin' ); ?></h2>
					<h3><?php esc_html_e( 'Being best at something feels great. Every Business desires a smooth buyer’s journey, WE ARE BEST AT IT.', 'mwb-sample-plugin' ); ?></h3>
				</div>
				<div class="mwb-msp-active-plugins-list">
					<?php
					$mwb_msp_all_plugins = get_option( 'mwb_all_plugins_active', false );
					if ( is_array( $mwb_msp_all_plugins ) && ! empty( $mwb_msp_all_plugins ) ) {
						?>
						<table class="mwb-msp-table">
							<thead>
								<tr class="mwb-plugins-head-row">
									<th><?php esc_html_e( 'Plugin Name', 'mwb-sample-plugin' ); ?></th>
									<th><?php esc_html_e( 'Active Status', 'mwb-sample-plugin' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( is_array( $mwb_msp_all_plugins ) && ! empty( $mwb_msp_all_plugins ) ) { ?>
									<?php foreach ( $mwb_msp_all_plugins as $msp_plugin_key => $msp_plugin_value ) { ?>
										<tr class="mwb-plugins-row">
											<td><?php echo esc_html( $msp_plugin_value['plugin_name'] ); ?></td>
											<?php if ( isset( $msp_plugin_value['active'] ) && '1' != $msp_plugin_value['active'] ) { ?>
												<td><?php esc_html_e( 'NO', 'mwb-sample-plugin' ); ?></td>
											<?php } else { ?>
												<td><?php esc_html_e( 'YES', 'mwb-sample-plugin' ); ?></td>
											<?php } ?>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<?php
					}
					?>
				</div>
			</div>
		</div>
