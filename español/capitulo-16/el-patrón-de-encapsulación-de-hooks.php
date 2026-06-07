<?php
namespace NinjaTheme;

class Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
    }

    public function enqueue(): void
    {
        wp_enqueue_style(
            'ninjatheme-main',
            get_template_directory_uri() . '/assets/css/main.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'ninjatheme-main',
            get_template_directory_uri() . '/assets/js/main.js',
            [],
            '1.0.0',
            true
        );
    }
}
