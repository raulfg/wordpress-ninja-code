<?php

declare(strict_types=1);

namespace NinjaTheme;

use NinjaTheme\Assets;
use NinjaTheme\PostTypes\Portfolio;
use NinjaTheme\Taxonomies\PortfolioCategory;

class Theme
{
    private static ?Theme $instance = null;

    private function __construct()
    {
        add_action( 'after_setup_theme', [ $this, 'setup' ] );
        add_action( 'init', [ $this, 'register_content_types' ] );

        new Assets();
        new Portfolio();
        new PortfolioCategory();
    }

    public static function get_instance(): Theme
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setup(): void
    {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
        add_theme_support( 'custom-logo' );

        register_nav_menus( [
            'primary' => 'Menú principal',
            'footer'  => 'Menú de pie de página',
        ] );
    }

    public function register_content_types(): void
    {
        // El registro real ocurre en Portfolio y PortfolioCategory,
        // que registran sus propios hooks en el constructor.
        // Este método queda disponible para lógica de init adicional.
    }
}
