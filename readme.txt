=== WP SMS Gateway ===
Contributors: kushaldhola
Tags: sms, sms gateway, android, bulk sms, notifications
Requires at least: 5.6
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Send single and bulk SMS from your WordPress admin using the free SMS Gateway for Android Cloud API.

== Description ==

WP SMS Gateway lets you send SMS messages directly from the WordPress dashboard by connecting to the [SMS Gateway for Android](https://sms-gate.app/) Cloud API. Turn any Android phone into an SMS gateway, then send single messages or bulk campaigns from a CSV file, with delivery logs kept for every message.

**Features**

* Send a single SMS to any number from the admin dashboard.
* Send bulk SMS from an uploaded CSV file (with a `mobile` and optional `message` column).
* Configurable delay between bulk messages to avoid overloading the gateway device.
* Automatic country code prefixing for numbers without one.
* Full send log (number, message, status, response, timestamp).
* Nonce-protected, capability-checked AJAX endpoints.

**Requirements**

* An Android device running the [SMS Gateway for Android](https://sms-gate.app/) app in Cloud mode.
* Your SMS Gateway Cloud username, password, and device ID.

== Installation ==

1. Upload the `wp-sms-gateway` folder to `/wp-content/plugins/`, or install the zip via **Plugins → Add New → Upload Plugin**.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Go to **SMS Gateway → Settings** and enter your SMS Gateway Cloud username, password, and device ID.
4. Go to **SMS Gateway → Send SMS** to send a single message or a bulk CSV batch.

== Frequently Asked Questions ==

= Where do I get a username, password, and device ID? =

Install the SMS Gateway for Android app on the phone you want to send from, enable Cloud mode, and it will display your credentials and device ID.

= What format should the bulk CSV file be? =

A header row followed by a `mobile` column, and optionally a `message` column if you want per-row custom messages instead of one message for everyone.

= Does this store my SMS Gateway password securely? =

The password is stored using the standard WordPress Options API. As with any credential stored in the database, we recommend restricting admin access and using a dedicated SMS Gateway account.

== Changelog ==

= 1.1.0 =
* Refactored into a standard, class-based plugin structure with separate admin views, JS, and CSS.
* Added nonce verification and capability checks to AJAX endpoints.
* Added uninstall cleanup for the logs table and plugin options.

= 1.0.0 =
* Initial release.
