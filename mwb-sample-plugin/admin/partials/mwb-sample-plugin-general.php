<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $msp_mwb_msp_obj;
$msp_genaral_settings = apply_filters( 'msp_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="msp-secion-wrap">
	<table class="form-table msp-settings-table">
		<?php
			$msp_general_html = $msp_mwb_msp_obj->mwb_msp_plug_generate_html( $msp_genaral_settings );
			echo esc_html( $msp_general_html );
		?>
	</table>
</div>
