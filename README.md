# WP SMS Gateway

Send single and bulk SMS messages from your WordPress admin dashboard using the free [SMS Gateway for Android](https://sms-gate.app/) Cloud API.

## Features

- 📱 Send a single SMS from the WordPress dashboard
- 📤 Send bulk SMS from an uploaded CSV file
- ⏱ Configurable delay between bulk messages
- 🌍 Automatic country code prefixing for numbers without one
- 🧾 Full send log (number, message, status, response, timestamp)
- 🔒 Nonce-protected, capability-checked AJAX endpoints

## Requirements

- WordPress 5.6+
- PHP 7.4+
- An Android device running [SMS Gateway for Android](https://sms-gate.app/) in Cloud mode

## Installation

1. Download or clone this repository into `wp-content/plugins/wp-sms-gateway`, or zip the folder and install it via **Plugins → Add New → Upload Plugin**.
2. Activate **WP SMS Gateway** from the **Plugins** screen.
3. Go to **SMS Gateway → Settings** and enter your SMS Gateway Cloud username, password, and device ID.
4. Go to **SMS Gateway → Send SMS** to send a message.

```bash
git clone https://github.com/yourusername/wp-sms-gateway.git wp-content/plugins/wp-sms-gateway
```

## Usage

### Single SMS

Go to **SMS Gateway → Send SMS**, enter a mobile number and message, and click **Send SMS**.

### Bulk SMS

1. Prepare a CSV file with a `mobile` column and an optional `message` column.
2. Go to **SMS Gateway → Send SMS**, upload the CSV under **Bulk SMS**.
3. Either type one message for everyone, or check **Use message column from CSV** to send a custom message per row.
4. Click **Send Bulk SMS**. Messages are sent with the delay configured in **Settings** to avoid overloading the gateway device.

### Logs

**SMS Gateway → SMS Logs** shows the last 500 messages sent, including status and the raw API response.

## File Structure

```
wp-sms-gateway/
├── wp-sms-gateway.php              # Plugin bootstrap
├── uninstall.php                   # Cleanup on uninstall
├── includes/
│   ├── class-wp-sms-gateway.php        # Core controller (singleton)
│   ├── class-wp-sms-gateway-admin.php  # Menus, assets, view rendering
│   ├── class-wp-sms-gateway-ajax.php   # AJAX handlers (single/bulk send)
│   ├── class-wp-sms-gateway-api.php    # SMS Gateway Cloud API client
│   └── class-wp-sms-gateway-db.php     # Logs table + queries
├── admin/
│   ├── css/admin.css
│   ├── js/admin.js
│   └── views/
│       ├── send-page.php
│       ├── settings-page.php
│       └── logs-page.php
├── languages/                      # Translation files (.pot/.po/.mo)
├── readme.txt                      # WordPress.org-format readme
└── README.md
```

## Security

- All AJAX requests are protected with a WordPress nonce (`check_ajax_referer`) and a `manage_options` capability check.
- All output is escaped with `esc_html()`, `esc_attr()`, or `esc_textarea()`.
- All input is sanitized with `sanitize_text_field()` / `sanitize_textarea_field()`.

## Changelog

### 1.1.0
- Refactored into a standard, class-based plugin structure with separate admin views, JS, and CSS.
- Added nonce verification and capability checks to AJAX endpoints.
- Added uninstall cleanup for the logs table and plugin options.

### 1.0.0
- Initial release.

## License

GPLv2 or later — see [LICENSE](LICENSE).
