<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers admin menus, enqueues assets, and renders the view files.
 */
class WP_SMS_Gateway_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Register the top-level menu and submenus.
	 */
	public function register_menus() {

		add_menu_page(
			__( 'SMS Gateway', 'wp-sms-gateway' ),
			__( 'SMS Gateway', 'wp-sms-gateway' ),
			'manage_options',
			'wpsms',
			array( $this, 'render_send_page' ),
			'dashicons-email-alt'
		);

		add_submenu_page(
			'wpsms',
			__( 'Send SMS', 'wp-sms-gateway' ),
			__( 'Send SMS', 'wp-sms-gateway' ),
			'manage_options',
			'wpsms',
			array( $this, 'render_send_page' )
		);

		add_submenu_page(
			'wpsms',
			__( 'SMS Logs', 'wp-sms-gateway' ),
			__( 'SMS Logs', 'wp-sms-gateway' ),
			'manage_options',
			'wpsms-logs',
			array( $this, 'render_logs_page' )
		);

		add_submenu_page(
			'wpsms',
			__( 'Settings', 'wp-sms-gateway' ),
			__( 'Settings', 'wp-sms-gateway' ),
			'manage_options',
			'wpsms-settings',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Load JS/CSS only on this plugin's admin screens.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_assets( $hook ) {

		if ( strpos( $hook, 'wpsms' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'wpsms-gateway-admin',
			WPSMS_GATEWAY_URL . 'admin/css/admin.css',
			array(),
			WPSMS_GATEWAY_VERSION
		);

		wp_enqueue_script(
			'wpsms-gateway-admin',
			WPSMS_GATEWAY_URL . 'admin/js/admin.js',
			array( 'jquery' ),
			WPSMS_GATEWAY_VERSION,
			true
		);

		wp_localize_script(
			'wpsms-gateway-admin',
			'wpsmsGateway',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wpsms_gateway_nonce' ),
			)
		);
	}

	/**
	 * Handle settings form submission and render the settings view.
	 */
	public function render_settings_page() {

		if ( isset( $_POST['wpsms_save'] ) ) {

			check_admin_referer( 'wpsms_save_settings' );

			update_option( 'wpsms_username', sanitize_text_field( wp_unslash( $_POST['wpsms_username'] ?? '' ) ) );
			update_option( 'wpsms_password', sanitize_text_field( wp_unslash( $_POST['wpsms_password'] ?? '' ) ) );
			update_option( 'wpsms_device_id', sanitize_text_field( wp_unslash( $_POST['wpsms_device_id'] ?? '' ) ) );
			update_option( 'wpsms_country_code', sanitize_text_field( wp_unslash( $_POST['wpsms_country_code'] ?? '' ) ) );
			update_option( 'wpsms_save_message', sanitize_textarea_field( wp_unslash( $_POST['wpsms_save_message'] ?? '' ) ) );
			update_option( 'wpsms_delay', intval( $_POST['wpsms_delay'] ?? 40 ) );

			echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'wp-sms-gateway' ) . '</p></div>';
		}

		require WPSMS_GATEWAY_PATH . 'admin/views/settings-page.php';
	}

	/**
	 * Render the send-SMS view.
	 */
	public function render_send_page() {
		require WPSMS_GATEWAY_PATH . 'admin/views/send-page.php';
	}

	/**
	 * Render the logs view.
	 */
	public function render_logs_page() {
		$logs = WP_SMS_Gateway_DB::get_logs( 500 );
		require WPSMS_GATEWAY_PATH . 'admin/views/logs-page.php';
	}
}
