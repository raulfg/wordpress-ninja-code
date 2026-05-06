/**
 * Genera metadatos SEO de Yoast para todos los posts de un CPT.
 * Ejecutar una sola vez desde WP-CLI o desde un endpoint de administración.
 */
function ninjaTheme_seed_seo_meta( string $post_type ): void {
    $posts = get_posts( [
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ] );

    foreach ( $posts as $post ) {
        $title       = $post->post_title . ' — Portfolio | NinjaTheme';
        $description = wp_strip_all_tags( $post->post_excerpt );

        update_post_meta( $post->ID, '_yoast_wpseo_title',   $title );
        update_post_meta( $post->ID, '_yoast_wpseo_metadesc', $description );
    }
}
