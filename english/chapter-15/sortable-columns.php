add_filter(
    'manage_edit-portfolio_sortable_columns',
    function( array $columns ): array {
        $columns['year']   = 'project_year';
        $columns['client'] = 'client_name';
        return $columns;
    }
);

add_action( 'pre_get_posts', function( \WP_Query $query ): void {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'portfolio' !== $query->get( 'post_type' ) ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    if ( 'project_year' === $orderby ) {
        $query->set( 'meta_key', '_npe_project_year' );
        $query->set( 'orderby', 'meta_value_num' );
    } elseif ( 'client_name' === $orderby ) {
        $query->set( 'meta_key', '_npe_client_name' );
        $query->set( 'orderby', 'meta_value' );
    }
} );
