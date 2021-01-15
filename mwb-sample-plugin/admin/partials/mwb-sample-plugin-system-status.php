<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $msp_mwb_msp_obj;
$msp_default_status = $msp_mwb_msp_obj->mwb_msp_plug_system_status();
$msp_wordpress_details = is_array( $msp_default_status['wp'] ) && ! empty( $msp_default_status['wp'] ) ? $msp_default_status['wp'] : array();
$msp_php_details = is_array( $msp_default_status['php'] ) && ! empty( $msp_default_status['php'] ) ? $msp_default_status['php'] : array();
?>
<div class="mwb-msp-table-wrap">
	<div class="mwb-msp-table-inner-container">
		<table class="mwb-msp-table" id="mwb-msp-wp">
			<thead>
				<tr>
					<th><?php esc_html_e( 'WP Variables', 'mwb-sample-plugin' ); ?></th>
					<th><?php esc_html_e( 'WP Values', 'mwb-sample-plugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $msp_wordpress_details ) && ! empty( $msp_wordpress_details ) ) { ?>
					<?php foreach ( $msp_wordpress_details as $wp_key => $wp_value ) { ?>
						<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
							<tr>
								<td><?php echo esc_html( $wp_key ); ?></td>
								<td><?php echo esc_html( $wp_value ); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="mwb-msp-table-inner-container">
		<table class="mwb-msp-table" id="mwb-msp-php">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Sysytem Variables', 'mwb-sample-plugin' ); ?></th>
					<th><?php esc_html_e( 'System Values', 'mwb-sample-plugin' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( is_array( $msp_php_details ) && ! empty( $msp_php_details ) ) { ?>
					<?php foreach ( $msp_php_details as $php_key => $php_value ) { ?>
						<tr>
							<td><?php echo esc_html( $php_key ); ?></td>
							<td><?php echo esc_html( $php_value ); ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
