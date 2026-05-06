<?php
// src/Assets.php

namespace NinjaTheme;

class Assets
{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts',    [ $this, 'enqueue_frontend' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor' ] );
    }

    public function enqueue_frontend(): void
    {
        // Hoja de estilos compilada por @wordpress/scripts
        $asset = $this->get_asset_file( 'main' );

        wp_enqueue_style(
            'ninjatheme-main',
            NINJATHEME_URI . '/build/main.css',
            [],
            $asset['version']
        );

        wp_enqueue_script(
            'ninjatheme-main',
            NINJATHEME_URI . '/build/main.js',
            $asset['dependencies'],
            $asset['version'],
            [ 'in_footer' => true, 'strategy' => 'defer' ]
        );

        // Exponer datos de configuración al script
        wp_add_inline_script(
            'ninjatheme-main',
            'window.ninjaTheme = ' . wp_json_encode( [
                'homeUrl'    => home_url( '/' ),
                'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
                'nonce'      => wp_create_nonce( 'ninja_frontend' ),
                'isLoggedIn' => is_user_logged_in(),
            ] ),
            'before'
        );

        // Filtro para que los plugins puedan añadir datos al objeto global
        // Ejemplo de uso: apply_filters( 'ninjatheme_inline_data', $data )
        do_action( 'ninjatheme_enqueue_scripts' );
    }

    public function enqueue_admin( string $hook_suffix ): void
    {
        // Solo en pantallas de edición de contenido
        if ( ! in_array( $hook_suffix, [ 'post.php', 'post-new.php' ], true ) ) {
            return;
        }

        $asset = $this->get_asset_file( 'admin' );

        wp_enqueue_style(
            'ninjatheme-admin',
            NINJATHEME_URI . '/build/admin.css',
            [],
            $asset['version']
        );
    }

    public function enqueue_editor(): void
    {
        // Estilos del editor: el tema aplica tipografía del frontend al editor
        add_editor_style( 'build/editor.css' );
    }

    private function get_asset_file( string $handle ): array
    {
        $path = NINJATHEME_DIR . "/build/{$handle}.asset.php";

        return file_exists( $path )
            ? require $path
            : [ 'dependencies' => [], 'version' => NINJATHEME_VERSION ];
    }
}
