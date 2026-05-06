add_action( 'pre_get_posts', function( WP_Query $query ): void {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'portfolio' ) ) {
        $query->set( 'posts_per_page', 12 );
        $query->set( 'meta_key', '_npe_project_year' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'order', 'DESC' );
        return; // Salir explícitamente para no ejecutar las demás condiciones
    }

    if ( $query->is_tax( 'portfolio-category' ) ) {
        $query->set( 'posts_per_page', 9 );
        return;
    }

    if ( $query->is_search() ) {
        $query->set( 'post_type', [ 'post', 'portfolio' ] );
        return;
    }
} );
