add_filter( 'the_content', 'ninja_add_related_posts' );

function ninja_add_related_posts( string $content ): string
{
    if ( ! is_single() || ! in_the_loop() ) {
        return $content;
    }

    $related = new WP_Query( [
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => [ get_the_ID() ],
    ] );

    $output = '';

    if ( $related->have_posts() ) {
        $output .= '<ul class="related-posts">';
        while ( $related->have_posts() ) {
            $related->the_post();
            $output .= sprintf(
                '<li><a href="%s">%s</a></li>',
                esc_url( get_permalink() ),
                esc_html( get_the_title() )
            );
        }
        $output .= '</ul>';
        wp_reset_postdata(); // Restores $post to the main Loop post.
    }

    return $content . $output;
}
