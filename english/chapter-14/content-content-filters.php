<?php
// src/Content.php

namespace NinjaTheme;

class Content
{
    public function __construct()
    {
        // Excerpts
        add_filter( 'excerpt_length',    [ $this, 'excerpt_length' ] );
        add_filter( 'excerpt_more',      [ $this, 'excerpt_more' ] );

        // Title in the <title> document element
        add_filter( 'document_title_separator', [ $this, 'title_separator' ] );

        // Body classes by context
        add_filter( 'body_class', [ $this, 'body_classes' ] );

        // Allow SVG uploads (needed for client logos)
        add_filter( 'upload_mimes', [ $this, 'allow_svg_upload' ] );

        // Clean wp_head of elements not used by this theme
        add_action( 'init', [ $this, 'clean_wp_head' ] );
    }

    public function excerpt_length( int $length ): int
    {
        // Apply only in the theme context, not in the admin
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
                    __( 'Continue reading %s', 'ninjatheme' ),
                    get_the_title()
                ) ),
                esc_html__( 'Read more', 'ninjatheme' )
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
        // Indicate if the user is browsing the portfolio
        if ( is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) ) {
            $classes[] = 'is-portfolio';
        }

        // Indicate if a sidebar is active on this page
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
        // Remove the link to the comments RSS feed — not used in NinjaTheme
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        // Remove the REST API link from the <head> (it is already exposed, the link is unnecessary)
        remove_action( 'wp_head', 'rest_output_link_wp_head' );

        // Remove the oEmbed discovery link if oEmbed is not used on the frontend
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove the WordPress version from the generator meta tag (basic security)
        remove_action( 'wp_head', 'wp_generator' );
    }
}
