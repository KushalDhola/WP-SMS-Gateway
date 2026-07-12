<?php
/**
 * View: SMS Logs page.
 *
 * @package WP_SMS_Gateway
 * @var array $logs Log rows passed in from WP_SMS_Gateway_Admin::render_logs_page().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap wpsms-wrap">

	<h1><?php esc_html_e( 'SMS Logs', 'wp-sms-gateway' ); ?></h1>

	<table class="widefat striped">

		<thead>
			<tr>
				<th><?php esc_html_e( 'ID', 'wp-sms-gateway' ); ?></th>
				<th><?php esc_html_e( 'Mobile', 'wp-sms-gateway' ); ?></th>
				<th><?php esc_html_e( 'Message', 'wp-sms-gateway' ); ?></th>
				<th><?php esc_html_e( 'Status', 'wp-sms-gateway' ); ?></th>
				<th><?php esc_html_e( 'Date', 'wp-sms-gateway' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php if ( empty( $logs ) ) : ?>
				<tr>
					<td colspan="5"><?php esc_html_e( 'No SMS have been sent yet.', 'wp-sms-gateway' ); ?></td>
				</tr>
			<?php else : ?>
				<?php foreach ( $logs as $log ) : ?>
					<tr>
						<td><?php echo esc_html( $log->id ); ?></td>
						<td><?php echo esc_html( $log->mobile ); ?></td>
						<td><?php echo esc_html( $log->message ); ?></td>
						<td><?php echo esc_html( ucfirst( $log->status ) ); ?></td>
						<td><?php echo esc_html( $log->created_at ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>

	</table>

</div>
