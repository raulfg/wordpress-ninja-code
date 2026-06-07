<?php
// src/Theme.php

namespace NinjaTheme;

use NinjaTheme\Assets;
use NinjaTheme\Content;
use NinjaTheme\Admin;

class Theme
{
    private static ?Theme $instance = null;

    private function __construct() {}

    public static function get_instance(): Theme
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setup(): void
    {
        // Registrar las características del tema
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Inicializar subsistemas
        new Assets();
        new Content();

        if ( is_admin() ) {
            new Admin();
        }
    }

    public function setup_theme(): void
    {
        // Text domain del tema
        load_theme_textdomain( 'ninjatheme', NINJATHEME_DIR . '/languages' );

        // Características de WordPress que el tema soporta
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ] );
        add_theme_support( 'custom-logo', [
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        ] );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'editor-styles' );

        // Tamaños de imagen propios del tema
        add_image_size( 'ninjatheme-card',     480, 320, true );
        add_image_size( 'ninjatheme-hero',     1920, 600, true );
        add_image_size( 'ninjatheme-portrait', 400, 600, true );

        // Menús de navegación
        register_nav_menus( [
            'primary'    => __( 'Menú principal', 'ninjatheme' ),
            'footer-col1' => __( 'Pie — columna 1', 'ninjatheme' ),
            'footer-col2' => __( 'Pie — columna 2', 'ninjatheme' ),
        ] );

        // Hook de extensibilidad: los plugins pueden añadir más soportes
        do_action( 'ninjatheme_after_setup' );
    }
}
