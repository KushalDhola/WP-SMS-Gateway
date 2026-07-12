<?php
/**
 * View: Send SMS page (single + bulk).
 *
 * @package WP_SMS_Gateway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap wpsms-wrap">

	<h1><?php esc_html_e( 'Send SMS', 'wp-sms-gateway' ); ?></h1>

	<div class="wpsms-card">

		<h2><?php esc_html_e( 'Single SMS', 'wp-sms-gateway' ); ?></h2>

		<input type="text" id="single_mobile" placeholder="<?php esc_attr_e( 'Mobile Number', 'wp-sms-gateway' ); ?>" class="regular-text">

		<textarea id="single_message" placeholder="<?php esc_attr_e( 'Message', 'wp-sms-gateway' ); ?>" class="large-text" rows="5"></textarea>

		<p>
			<button class="button button-primary" id="send_single">
				<?php esc_html_e( 'Send SMS', 'wp-sms-gateway' ); ?>
			</button>
		</p>

		<div id="single_result"></div>

	</div>

	<hr>

	<div class="wpsms-card">

		<h2><?php esc_html_e( 'Bulk SMS', 'wp-sms-gateway' ); ?></h2>

		<p>
			<input type="file" id="csv_file" accept=".csv">
			<span class="description">
				<?php esc_html_e( 'CSV must include a "mobile" column, and optionally a "message" column.', 'wp-sms-gateway' ); ?>
			</span>
		</p>

		<textarea id="same_message" placeholder="<?php esc_attr_e( 'Same message for all', 'wp-sms-gateway' ); ?>" class="large-text" rows="5"></textarea>

		<p>
			<label>
				<input type="checkbox" id="use_csv_message">
				<?php esc_html_e( 'Use message column from CSV', 'wp-sms-gateway' ); ?>
			</label>
		</p>

		<p>
			<button class="button button-primary" id="send_bulk">
				<?php esc_html_e( 'Send Bulk SMS', 'wp-sms-gateway' ); ?>
			</button>
		</p>

		<div id="bulk_result"></div>

	</div>

</div>
