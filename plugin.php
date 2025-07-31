<?php
/**
 * Plugin Name: OTGS Foo Banner
 * Plugin URI: https://wpml.org/
 * Description: This plugin shows a banner on the frontend header, but the purpose is to show the steps to internationalize (i18n) and localize (l10n) a WordPress plugin.
 * Author: OnTheGoSystems
 * Author URI: http://www.onthegosystems.com/
 * Version: 1.0.0
 * Text Domain: otgs-fb
 */

define( 'OTGS_FB_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once __DIR__ . '/php/functions.php';