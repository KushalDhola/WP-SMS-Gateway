<?php
/**
 * Plugin Name:       WP SMS Gateway
 * Plugin URI:        https://github.com/yourusername/wp-sms-gateway
 * Description:       Send single and bulk SMS messages from WordPress using the SMS Gateway for Android Cloud API.
 * Version:           1.1.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Kushal Dhola
 * Author URI:        https://github.com/yourusername
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-sms-gateway
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants.
define( 'WPSMS_GATEWAY_VERSION', '1.1.0' );
define( 'WPSMS_GATEWAY_FILE', __FILE__ );
define( 'WPSMS_GATEWAY_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPSMS_GATEWAY_URL', plugin_dir_url( __FILE__ ) );

// Load dependencies.
require_once WPSMS_GATEWAY_PATH . 'includes/class-wp-sms-gateway-db.php';
require_once WPSMS_GATEWAY_PATH . 'includes/class-wp-sms-gateway-api.php';
require_once WPSMS_GATEWAY_PATH . 'includes/class-wp-sms-gateway-admin.php';
require_once WPSMS_GATEWAY_PATH . 'includes/class-wp-sms-gateway-ajax.php';
require_once WPSMS_GATEWAY_PATH . 'includes/class-wp-sms-gateway.php';

// Activation hook (creates the logs table).
register_activation_hook( __FILE__, array( 'WP_SMS_Gateway_DB', 'create_table' ) );

/**
 * Boot the plugin.
 */
function wpsms_gateway_run() {
	return WP_SMS_Gateway::instance();
}
wpsms_gateway_run();
