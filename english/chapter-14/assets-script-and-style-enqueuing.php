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
        // Stylesheet compiled by @wordpress/scripts
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

        // Expose configuration data to the script
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

        // Filter so plugins can add data to the global object
        // Example usage: apply_filters( 'ninjatheme_inline_data', $data )
        do_action( 'ninjatheme_enqueue_scripts' );
    }

    public function enqueue_admin( string $hook_suffix ): void
    {
        // Only on content editing screens
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
        // Editor styles: the theme applies frontend typography to the editor
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
