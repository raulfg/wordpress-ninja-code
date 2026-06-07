add_action( 'pre_get_posts', function ( WP_Query $query ): void {
    if ( ! $query->is_main_query() || is_admin() ) {
        return;
    }

    // In the portfolio archive: 12 projects ordered by date
    if ( $query->is_post_type_archive( 'portfolio' ) ) {
        $query->set( 'posts_per_page', 12 );
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );
    }

    // In portfolio taxonomy archives
    if ( $query->is_tax( 'portfolio-category' ) ) {
        $query->set( 'posts_per_page', 12 );
    }
} );
