<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core plugin controller. Wires together the API, DB, admin, and AJAX classes.
 */
final class WP_SMS_Gateway {

	/**
	 * @var WP_SMS_Gateway|null
	 */
	private static $instance = null;

	/**
	 * @var WP_SMS_Gateway_API
	 */
	public $api;

	/**
	 * @var WP_SMS_Gateway_Admin
	 */
	public $admin;

	/**
	 * @var WP_SMS_Gateway_Ajax
	 */
	public $ajax;

	/**
	 * Get the singleton instance.
	 *
	 * @return WP_SMS_Gateway
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->api = new WP_SMS_Gateway_API();

		if ( is_admin() ) {
			$this->admin = new WP_SMS_Gateway_Admin();
		}

		$this->ajax = new WP_SMS_Gateway_Ajax( $this->api );

		load_plugin_textdomain( 'wp-sms-gateway', false, dirname( plugin_basename( WPSMS_GATEWAY_FILE ) ) . '/languages' );
	}

	// Prevent cloning and unserialization of the singleton.
	private function __clone() {}
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize a singleton.' );
	}
}
