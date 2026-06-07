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
        // Register theme features
        add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

        // Initialize subsystems
        new Assets();
        new Content();

        if ( is_admin() ) {
            new Admin();
        }
    }

    public function setup_theme(): void
    {
        // Theme text domain
        load_theme_textdomain( 'ninjatheme', NINJATHEME_DIR . '/languages' );

        // WordPress features supported by this theme
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

        // Custom image sizes for the theme
        add_image_size( 'ninjatheme-card',     480, 320, true );
        add_image_size( 'ninjatheme-hero',     1920, 600, true );
        add_image_size( 'ninjatheme-portrait', 400, 600, true );

        // Navigation menus
        register_nav_menus( [
            'primary'    => __( 'Primary menu', 'ninjatheme' ),
            'footer-col1' => __( 'Footer — column 1', 'ninjatheme' ),
            'footer-col2' => __( 'Footer — column 2', 'ninjatheme' ),
        ] );

        // Extensibility hook: plugins can add more supports
        do_action( 'ninjatheme_after_setup' );
    }
}
