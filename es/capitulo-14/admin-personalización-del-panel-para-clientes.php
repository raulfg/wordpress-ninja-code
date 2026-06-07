<?php
// src/Admin.php

namespace NinjaTheme;

class Admin
{
    public function __construct()
    {
        // Solo para usuarios que NO son administradores (simplificar la UI para el cliente)
        if ( current_user_can( 'manage_options' ) ) {
            return;
        }

        add_action( 'admin_bar_menu',   [ $this, 'clean_admin_bar' ], 999 );
        add_action( 'admin_menu',       [ $this, 'clean_admin_menu' ] );
        add_filter( 'admin_footer_text', [ $this, 'custom_footer_text' ] );
    }

    public function clean_admin_bar( \WP_Admin_Bar $wp_admin_bar ): void
    {
        // Quitar elementos del admin bar que confunden al cliente
        $wp_admin_bar->remove_node( 'wp-logo' );
        $wp_admin_bar->remove_node( 'comments' );
        $wp_admin_bar->remove_node( 'new-content' );
    }

    public function clean_admin_menu(): void
    {
        // Ocultar menús que el cliente no necesita tocar
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'plugins.php' );
    }

    public function custom_footer_text( string $text ): string
    {
        return sprintf(
            __( 'Desarrollado por <a href="%s">NinjaTheme</a>', 'ninjatheme' ),
            esc_url( 'https://ninjatheme.dev' )
        );
    }
}
