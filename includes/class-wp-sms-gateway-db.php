<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the custom logs table: creation, inserts, and reads.
 */
class WP_SMS_Gateway_DB {

	/**
	 * Get the fully prefixed table name.
	 *
	 * @return string
	 */
	public static function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'sms_gateway_logs';
	}

	/**
	 * Create the logs table on activation.
	 */
	public static function create_table() {
		global $wpdb;

		$table_name      = self::table_name();
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			mobile VARCHAR(20) NOT NULL,
			message LONGTEXT NOT NULL,
			status VARCHAR(20) NOT NULL,
			response LONGTEXT NULL,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Insert a log row.
	 *
	 * @param string $mobile   Destination number.
	 * @param string $message  Message body.
	 * @param string $status   'sent' or 'failed'.
	 * @param mixed  $response Raw API response.
	 */
	public static function save_log( $mobile, $message, $status, $response ) {
		global $wpdb;

		$wpdb->insert(
			self::table_name(),
			array(
				'mobile'   => $mobile,
				'message'  => $message,
				'status'   => $status,
				'response' => maybe_serialize( $response ),
			),
			array( '%s', '%s', '%s', '%s' )
		);
	}

	/**
	 * Fetch the most recent log rows.
	 *
	 * @param int $limit Number of rows to return.
	 * @return array
	 */
	public static function get_logs( $limit = 500 ) {
		global $wpdb;

		$table = self::table_name();

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table} ORDER BY id DESC LIMIT %d",
				$limit
			)
		);
	}
}
