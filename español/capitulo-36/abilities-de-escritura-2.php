function ninja_execute_create_project( array $args ): array {
    $post_id = wp_insert_post( [
        'post_title'   => sanitize_text_field( $args['title'] ),
        'post_content' => wp_kses_post( $args['description'] ?? '' ),
        'post_type'    => 'portfolio',
        'post_status'  => 'publish',
    ], true );

    if ( is_wp_error( $post_id ) ) {
        return [ 'success' => false, 'id' => 0, 'url' => '' ];
    }

    if ( ! empty( $args['client'] ) ) {
        update_post_meta( $post_id, '_npe_client_name', sanitize_text_field( $args['client'] ) );
    }

    if ( ! empty( $args['year'] ) ) {
        update_post_meta( $post_id, '_npe_project_year', (int) $args['year'] );
    }

    if ( ! empty( $args['featured'] ) ) {
        update_post_meta( $post_id, '_npe_is_featured', '1' );
    }

    if ( ! empty( $args['category'] ) ) {
        $term = get_term_by( 'slug', $args['category'], 'portfolio-category' );
        if ( $term ) {
            wp_set_post_terms( $post_id, [ $term->term_id ], 'portfolio-category' );
        }
    }

    return [
        'success' => true,
        'id'      => $post_id,
        'url'     => get_permalink( $post_id ),
    ];
}
