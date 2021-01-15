<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_sample_plugin
 * @subpackage Mwb_sample_plugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $msp_mwb_msp_obj;
$msp_active_tab   = isset( $_GET['msp_tab'] ) ? sanitize_key( $_GET['msp_tab'] ) : 'mwb-sample-plugin-general';
$msp_default_tabs = $msp_mwb_msp_obj->mwb_msp_plug_default_tabs();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mwb-msp-main-wrapper">
	<div class="mwb-msp-go-pro">
		<div class="mwb-msp-go-pro-banner">
			<div class="mwb-msp-inner-container">
				<div class="mwb-msp-name-wrapper">
					<p><?php esc_html_e( 'mwb-sample-plugin', 'mwb-sample-plugin' ); ?></p></div>
					<div class="mwb-msp-static-menu">
						<ul>
							<li>
								<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/' ); ?>" target="_blank">
									<span class="dashicons dashicons-phone"></span>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/hubspot-woocommerce-integration/' ); ?>" target="_blank">
									<span class="dashicons dashicons-media-document"></span>
								</a>
							</li>
							<?php $msp_plugin_pro_link = apply_filters( 'msp_pro_plugin_link', '' ); ?>
							<?php if ( isset( $msp_plugin_pro_link ) && '' != $msp_plugin_pro_link ) { ?>
								<li class="mwb-msp-main-menu-button">
									<a id="mwb-msp-go-pro-link" href="<?php echo esc_url( $msp_plugin_pro_link ); ?>" class="" title="" target="_blank"><?php esc_html_e( 'GO PRO NOW', 'mwb-sample-plugin' ); ?></a>
								</li>
							<?php } else { ?>
								<li class="mwb-msp-main-menu-button">
									<a id="mwb-msp-go-pro-link" href="#" class="" title=""><?php esc_html_e( 'GO PRO NOW', 'mwb-sample-plugin' ); ?></a>
								</li>
							<?php } ?>
							<?php $msp_plugin_pro = apply_filters( 'msp_pro_plugin_purcahsed', 'no' ); ?>
							<?php if ( isset( $msp_plugin_pro ) && 'yes' == $msp_plugin_pro ) { ?>
								<li>
									<a id="mwb-msp-skype-link" href="<?php echo esc_url( 'https://join.skype.com/invite/IKVeNkLHebpC' ); ?>" target="_blank">
										<img src="<?php echo esc_url( MWB_SAMPLE_PLUGIN_DIR_URL . 'admin/images/skype_logo.png' ); ?>" style="height: 15px;width: 15px;" ><?php esc_html_e( 'Chat Now', 'mwb-sample-plugin' ); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="mwb-msp-main-template">
			<div class="mwb-msp-body-template">
				<div class="mwb-msp-navigator-template">
					<div class="mwb-msp-navigations">
						<?php
						if ( is_array( $msp_default_tabs ) && ! empty( $msp_default_tabs ) ) {

							foreach ( $msp_default_tabs as $msp_tab_key => $msp_default_tabs ) {

								$msp_tab_classes = 'mwb-msp-nav-tab ';

								if ( ! empty( $msp_active_tab ) && $msp_active_tab === $msp_tab_key ) {
									$msp_tab_classes .= 'msp-nav-tab-active';
								}
								?>
								
								<div class="mwb-msp-tabs">
									<a class="<?php echo esc_attr( $msp_tab_classes ); ?>" id="<?php echo esc_attr( $msp_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mwb_sample_plugin_menu' ) . '&msp_tab=' . esc_attr( $msp_tab_key ) ); ?>"><?php echo esc_html( $msp_default_tabs['title'] ); ?></a>
								</div>

								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="mwb-msp-content-template">
					<div class="mwb-msp-content-container">
						<?php
							// if submenu is directly clicked on woocommerce.
						if ( empty( $msp_active_tab ) ) {

							$msp_active_tab = 'mwb_msp_plug_general';
						}

							// look for the path based on the tab id in the admin templates.
						$msp_tab_content_path = 'admin/partials/' . $msp_active_tab . '.php';

						$msp_mwb_msp_obj->mwb_msp_plug_load_template( $msp_tab_content_path );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
