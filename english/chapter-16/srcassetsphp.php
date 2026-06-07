<?php

declare(strict_types=1);

namespace NinjaTheme;

class Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin' ] );
    }

    public function enqueue_frontend(): void
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

    public function enqueue_admin(): void
    {
        wp_enqueue_style(
            'ninjatheme-admin',
            get_template_directory_uri() . '/assets/css/admin.css',
            [],
            '1.0.0'
        );
    }
}
