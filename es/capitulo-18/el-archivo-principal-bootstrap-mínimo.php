<?php
/**
 * Plugin Name: Ninja Portfolio Enhancer
 * ...resto del header...
 */

// Impide el acceso directo al archivo.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NPE_VERSION', '1.0.0' );
define( 'NPE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NPE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once NPE_PLUGIN_DIR . 'vendor/autoload.php';

// Hooks de ciclo de vida (deben registrarse desde el archivo raíz).
register_activation_hook( __FILE__, [ 'NinjaPortfolio\\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'NinjaPortfolio\\Plugin', 'deactivate' ] );

add_action( 'plugins_loaded', function () {
    NinjaPortfolio\Plugin::get_instance();
} );
