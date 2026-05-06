<?php
// src/Content.php

namespace NinjaTheme;

class Content
{
    public function __construct()
    {
        // Extractos
        add_filter( 'excerpt_length',    [ $this, 'excerpt_length' ] );
        add_filter( 'excerpt_more',      [ $this, 'excerpt_more' ] );

        // Título en el documento <title>
        add_filter( 'document_title_separator', [ $this, 'title_separator' ] );

        // Clases del body por contexto
        add_filter( 'body_class', [ $this, 'body_classes' ] );

        // Permitir SVG en upload (necesario para logos de clientes)
        add_filter( 'upload_mimes', [ $this, 'allow_svg_upload' ] );

        // Limpiar el wp_head de elementos que no se usan en este tema
        add_action( 'init', [ $this, 'clean_wp_head' ] );
    }

    public function excerpt_length( int $length ): int
    {
        // Aplicar solo en el contexto del tema, no en el admin
        if ( is_admin() ) {
            return $length;
        }

        return apply_filters( 'ninjatheme_excerpt_length', 28 );
    }

    public function excerpt_more( string $more ): string
    {
        if ( ! is_singular() ) {
            return sprintf(
                ' <a href="%s" class="read-more" aria-label="%s">%s</a>',
                esc_url( get_permalink() ),
                esc_attr( sprintf(
                    /* translators: %s: post title */
                    __( 'Continuar leyendo %s', 'ninjatheme' ),
                    get_the_title()
                ) ),
                esc_html__( 'Leer más', 'ninjatheme' )
            );
        }

        return '';
    }

    public function title_separator( string $sep ): string
    {
        return '—';
    }

    public function body_classes( array $classes ): array
    {
        // Indicar si el usuario está navegando por el portfolio
        if ( is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) ) {
            $classes[] = 'is-portfolio';
        }

        // Indicar si hay sidebar activa en esta página
        if ( is_active_sidebar( 'sidebar-main' ) && is_singular() ) {
            $classes[] = 'has-sidebar';
        }

        return $classes;
    }

    public function allow_svg_upload( array $mimes ): array
    {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';

        return $mimes;
    }

    public function clean_wp_head(): void
    {
        // Quitar el enlace al feed RSS de los comentarios — no se usa en NinjaTheme
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        // Quitar el enlace a la API REST del <head> (ya está expuesta, el link es innecesario)
        remove_action( 'wp_head', 'rest_output_link_wp_head' );

        // Quitar el oEmbed discovery link si no se usa oEmbed en el frontend
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Quitar la versión de WordPress del generador meta (seguridad básica)
        remove_action( 'wp_head', 'wp_generator' );
    }
}
