<?php
namespace NinjaTheme;

class Setup
{
    private static ?Setup $instance = null;

    private function __construct()
    {
        add_action( 'after_setup_theme', [ $this, 'setup' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public static function get_instance(): Setup
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setup(): void
    {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery' ] );
    }

    public function enqueue_assets(): void
    {
        wp_enqueue_style(
            'ninjatheme-main',
            get_template_directory_uri() . '/assets/css/main.css',
            [],
            '1.0.0'
        );
    }
}
