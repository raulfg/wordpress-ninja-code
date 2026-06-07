<?php
/**
 * Plugin Name: Ninja Portfolio Enhancer
 * Plugin URI:  https://ejemplo.com
 * Description: Portfolio CPT with taxonomies and metadata for NinjaTheme.
 * Version:     1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.1
 * Text Domain: ninja-portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NPE_VERSION',    '1.0.0' );
define( 'NPE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NPE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once NPE_PLUGIN_DIR . 'vendor/autoload.php';

register_activation_hook(   __FILE__, [ 'NinjaPortfolio\\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'NinjaPortfolio\\Plugin', 'deactivate' ] );
register_uninstall_hook(    __FILE__, [ 'NinjaPortfolio\\Plugin', 'uninstall' ] );

add_action( 'plugins_loaded', function(): void {
    NinjaPortfolio\Plugin::get_instance();
} );
