add_action( 'pre_get_posts', function ( WP_Query $query ): void {
    if ( ! $query->is_main_query() || is_admin() ) {
        return;
    }

    // En el archivo del portfolio: 12 proyectos ordenados por fecha
    if ( $query->is_post_type_archive( 'portfolio' ) ) {
        $query->set( 'posts_per_page', 12 );
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );
    }

    // En los archivos de taxonomías del portfolio
    if ( $query->is_tax( 'portfolio-category' ) ) {
        $query->set( 'posts_per_page', 12 );
    }
} );
