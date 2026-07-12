<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Talks to the SMS Gateway for Android Cloud API and normalizes numbers.
 *
 * @see https://sms-gate.app/
 */
class WP_SMS_Gateway_API {

	const API_ENDPOINT = 'https://api.sms-gate.app/3rdparty/v1/message';

	/**
	 * Normalize a mobile number to E.164-ish format using the
	 * configured default country code.
	 *
	 * @param string $mobile Raw mobile number.
	 * @return string
	 */
	public function fix_mobile_number( $mobile ) {

		// Strip everything except digits and a leading +.
		$mobile = preg_replace( '/[^0-9+]/', '', $mobile );

		if ( 0 === strpos( $mobile, '+' ) ) {
			return $mobile;
		}

		// Remove leading zeros (local trunk prefix).
		$mobile = ltrim( $mobile, '0' );

		$country_code = sanitize_text_field( get_option( 'wpsms_country_code', '91' ) );

		if ( 0 !== strpos( $country_code, '+' ) ) {
			$country_code = '+' . $country_code;
		}

		return $country_code . $mobile;
	}

	/**
	 * Send a single SMS via the Cloud API.
	 *
	 * @param string $mobile  E.164 formatted number.
	 * @param string $message Message body.
	 * @return array {
	 *     @type string $status   'sent' or 'failed'.
	 *     @type string $response Raw response body or error message.
	 * }
	 */
	public function send( $mobile, $message ) {

		$username  = get_option( 'wpsms_username' );
		$password  = get_option( 'wpsms_password' );
		$device_id = get_option( 'wpsms_device_id' );

		$body = array(
			'message'      => $message,
			'phoneNumbers' => array( $mobile ),
			'deviceId'     => $device_id,
		);

		$response = wp_remote_post(
			self::API_ENDPOINT,
			array(
				'method'  => 'POST',
				'timeout' => 60,
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode( $body ),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'status'   => 'failed',
				'response' => $response->get_error_message(),
			);
		}

		return array(
			'status'   => 'sent',
			'response' => wp_remote_retrieve_body( $response ),
		);
	}
}
