<?php
/**
 * View: Settings page.
 *
 * @package WP_SMS_Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap wpsms-wrap">

	<h1><?php esc_html_e( 'SMS Gateway Settings', 'wp-sms-gateway' ); ?></h1>

	<form method="post">

		<?php wp_nonce_field( 'wpsms_save_settings' ); ?>

		<table class="form-table">

			<tr>
				<th><label for="wpsms_username"><?php esc_html_e( 'Username', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<input type="text" id="wpsms_username" name="wpsms_username" class="regular-text"
						value="<?php echo esc_attr( get_option( 'wpsms_username' ) ); ?>">
				</td>
			</tr>

			<tr>
				<th><label for="wpsms_password"><?php esc_html_e( 'Password', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<input type="password" id="wpsms_password" name="wpsms_password" class="regular-text"
						value="<?php echo esc_attr( get_option( 'wpsms_password' ) ); ?>" autocomplete="new-password">
				</td>
			</tr>

			<tr>
				<th><label for="wpsms_device_id"><?php esc_html_e( 'Device ID', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<input type="text" id="wpsms_device_id" name="wpsms_device_id" class="regular-text"
						value="<?php echo esc_attr( get_option( 'wpsms_device_id' ) ); ?>">
				</td>
			</tr>

			<tr>
				<th><label for="wpsms_delay"><?php esc_html_e( 'Delay Between SMS (seconds)', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<input type="number" id="wpsms_delay" name="wpsms_delay" min="0"
						value="<?php echo esc_attr( get_option( 'wpsms_delay', 40 ) ); ?>">
				</td>
			</tr>

			<tr>
				<th><label for="wpsms_country_code"><?php esc_html_e( 'Country Code (without +)', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<input type="number" id="wpsms_country_code" name="wpsms_country_code"
						value="<?php echo esc_attr( get_option( 'wpsms_country_code', 91 ) ); ?>">
				</td>
			</tr>

			<tr>
				<th><label for="wpsms_save_message"><?php esc_html_e( 'Default Message', 'wp-sms-gateway' ); ?></label></th>
				<td>
					<textarea id="wpsms_save_message" name="wpsms_save_message" class="regular-text" rows="4"><?php echo esc_textarea( get_option( 'wpsms_save_message' ) ); ?></textarea>
				</td>
			</tr>

		</table>

		<p>
			<button class="button button-primary" name="wpsms_save" value="1">
				<?php esc_html_e( 'Save Settings', 'wp-sms-gateway' ); ?>
			</button>
		</p>

	</form>

</div>
