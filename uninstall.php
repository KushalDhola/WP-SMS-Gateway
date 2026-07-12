<?php
/**
 * Fired when the plugin is deleted via the Plugins screen.
 * Removes the custom table and stored options.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$table = $wpdb->prefix . 'sms_gateway_logs';

$wpdb->query( "DROP TABLE IF EXISTS {$table}" );

$options = array(
	'wpsms_username',
	'wpsms_password',
	'wpsms_device_id',
	'wpsms_country_code',
	'wpsms_save_message',
	'wpsms_delay',
);

foreach ( $options as $option ) {
	delete_option( $option );
}
