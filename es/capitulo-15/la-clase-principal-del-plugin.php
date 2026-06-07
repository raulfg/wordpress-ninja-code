<?php
namespace NinjaPortfolio;

use NinjaPortfolio\PostTypes\Portfolio;
use NinjaPortfolio\Taxonomies\PortfolioCategory;

class Plugin
{
    private static ?Plugin $instance = null;

    private function __construct()
    {
        new Portfolio();
        new PortfolioCategory();

        add_action( 'init', [ $this, 'register_meta' ] );

        // Carga el text domain
        add_action( 'init', function(): void {
            load_plugin_textdomain(
                'ninja-portfolio',
                false,
                dirname( plugin_basename( NPE_PLUGIN_DIR ) ) . '/languages'
            );
        } );
    }

    public static function get_instance(): Plugin
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register_meta(): void
    {
        $meta_fields = [
            '_npe_project_url' => [
                'type'              => 'string',
                'description'       => 'URL del proyecto en producción',
                'sanitize_callback' => 'esc_url_raw',
            ],
            '_npe_client_name' => [
                'type'              => 'string',
                'description'       => 'Nombre del cliente',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            '_npe_project_year' => [
                'type'              => 'integer',
                'description'       => 'Año de realización del proyecto',
                'sanitize_callback' => 'absint',
            ],
            '_npe_is_featured' => [
                'type'              => 'boolean',
                'description'       => 'Marcar como proyecto destacado',
                'sanitize_callback' => 'rest_sanitize_boolean',
            ],
        ];

        foreach ( $meta_fields as $key => $args ) {
            register_post_meta( 'portfolio', $key, array_merge( [
                'single'       => true,
                'show_in_rest' => true,
                'auth_callback' => fn() => current_user_can( 'edit_posts' ),
            ], $args ) );
        }
    }

    public static function activate(): void
    {
        // Registrar el CPT y las taxonomías para que flush_rewrite_rules funcione
        ( new Portfolio() )->register();
        ( new PortfolioCategory() )->register();
        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }

    public static function uninstall(): void
    {
        if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
            exit;
        }

        $settings = get_option( 'npe_settings', [] );
        if ( ! empty( $settings['keep_data'] ) ) {
            return;
        }

        // Eliminar todos los proyectos del portfolio
        $portfolios = get_posts( [
            'post_type'   => 'portfolio',
            'post_status' => 'any',
            'numberposts' => -1,
            'fields'      => 'ids',
        ] );

        foreach ( $portfolios as $id ) {
            wp_delete_post( $id, true );
        }

        // Eliminar las taxonomías
        $terms = get_terms( [
            'taxonomy'   => [ 'portfolio-category', 'portfolio-technology' ],
            'hide_empty' => false,
            'fields'     => 'ids',
        ] );

        foreach ( $terms as $term_id ) {
            wp_delete_term( $term_id, 'portfolio-category' );
        }

        // Eliminar opciones del plugin
        delete_option( 'npe_settings' );
    }
}
