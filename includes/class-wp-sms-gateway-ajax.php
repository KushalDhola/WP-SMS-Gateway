<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX endpoints for sending single and bulk SMS.
 */
class WP_SMS_Gateway_Ajax {

	/**
	 * @var WP_SMS_Gateway_API
	 */
	private $api;

	public function __construct( WP_SMS_Gateway_API $api ) {
		$this->api = $api;

		add_action( 'wp_ajax_wpsms_send_single', array( $this, 'send_single_sms' ) );
		add_action( 'wp_ajax_wpsms_send_bulk', array( $this, 'send_bulk_sms' ) );
	}

	/**
	 * Verify nonce + capability, common to both endpoints.
	 */
	private function guard() {
		check_ajax_referer( 'wpsms_gateway_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'You are not allowed to do this.', 'wp-sms-gateway' ), 403 );
		}
	}

	/**
	 * Handle sending a single SMS.
	 */
	public function send_single_sms() {

		$this->guard();

		$mobile  = sanitize_text_field( wp_unslash( $_POST['mobile'] ?? '' ) );
		$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

		if ( empty( $mobile ) || empty( $message ) ) {
			wp_send_json_error( __( 'Mobile number and message are required.', 'wp-sms-gateway' ) );
		}

		$mobile = $this->api->fix_mobile_number( $mobile );
		$result = $this->api->send( $mobile, $message );

		WP_SMS_Gateway_DB::save_log( $mobile, $message, $result['status'], $result['response'] );

		if ( 'sent' === $result['status'] ) {
			wp_send_json_success( __( 'SMS sent successfully.', 'wp-sms-gateway' ) );
		}

		wp_send_json_error( __( 'Failed to send SMS.', 'wp-sms-gateway' ) );
	}

	/**
	 * Handle sending bulk SMS from an uploaded CSV.
	 *
	 * Expected CSV columns: mobile[, message]
	 */
	public function send_bulk_sms() {

		$this->guard();

		if ( empty( $_FILES['csv_file']['tmp_name'] ) || ! is_uploaded_file( $_FILES['csv_file']['tmp_name'] ) ) {
			wp_send_json_error( __( 'CSV file is missing.', 'wp-sms-gateway' ) );
		}

		$same_message     = sanitize_textarea_field( wp_unslash( $_POST['same_message'] ?? '' ) );
		$use_csv_message  = ! empty( $_POST['use_csv_message'] );
		$delay            = max( 0, intval( get_option( 'wpsms_delay', 40 ) ) );

		$file = fopen( $_FILES['csv_file']['tmp_name'], 'r' );

		if ( false === $file ) {
			wp_send_json_error( __( 'Unable to read the uploaded CSV.', 'wp-sms-gateway' ) );
		}

		$header = fgetcsv( $file );
		$count  = 0;

		while ( false !== ( $row = fgetcsv( $file ) ) ) {

			$data = array_combine( $header, $row );

			if ( empty( $data['mobile'] ) ) {
				continue;
			}

			$mobile = $this->api->fix_mobile_number( sanitize_text_field( $data['mobile'] ) );

			$message = ( $use_csv_message && ! empty( $data['message'] ) )
				? sanitize_textarea_field( $data['message'] )
				: $same_message;

			$result = $this->api->send( $mobile, $message );

			WP_SMS_Gateway_DB::save_log( $mobile, $message, $result['status'], $result['response'] );

			$count++;

			// Throttle so the Android gateway isn't flooded.
			if ( $delay > 0 ) {
				sleep( $delay );
			}
		}

		fclose( $file );

		wp_send_json_success(
			/* translators: %d: number of SMS sent */
			sprintf( __( '%d SMS sent successfully.', 'wp-sms-gateway' ), $count )
		);
	}
}
