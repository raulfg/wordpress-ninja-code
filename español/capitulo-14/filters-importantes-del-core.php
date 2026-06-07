add_filter( 'the_content', 'ninja_añadir_posts_relacionados' );

function ninja_añadir_posts_relacionados( string $content ): string
{
    if ( ! is_single() || ! in_the_loop() ) {
        return $content;
    }

    $relacionados = new WP_Query( [
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => [ get_the_ID() ],
    ] );

    $output = '';

    if ( $relacionados->have_posts() ) {
        $output .= '<ul class="related-posts">';
        while ( $relacionados->have_posts() ) {
            $relacionados->the_post();
            $output .= sprintf(
                '<li><a href="%s">%s</a></li>',
                esc_url( get_permalink() ),
                esc_html( get_the_title() )
            );
        }
        $output .= '</ul>';
        wp_reset_postdata(); // Restaura $post al post del Loop principal.
    }

    return $content . $output;
}
