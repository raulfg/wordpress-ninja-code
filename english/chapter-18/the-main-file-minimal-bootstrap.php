<?php
/**
 * Plugin Name: Ninja Portfolio Enhancer
 * ...rest of header...
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NPE_VERSION', '1.0.0' );
define( 'NPE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NPE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once NPE_PLUGIN_DIR . 'vendor/autoload.php';

// Lifecycle hooks (must be registered from the root file).
register_activation_hook( __FILE__, [ 'NinjaPortfolio\\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'NinjaPortfolio\\Plugin', 'deactivate' ] );

add_action( 'plugins_loaded', function () {
    NinjaPortfolio\Plugin::get_instance();
} );
