add_action( 'pre_get_posts', function( \WP_Query $query ): void {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'portfolio' !== $query->get( 'post_type' ) ) {
        return;
    }

    $meta_query = [];

    if ( isset( $_GET['portfolio_featured'] ) && -1 !== (int) $_GET['portfolio_featured'] ) {
        $meta_query[] = [
            'key'   => '_npe_is_featured',
            'value' => '1' === $_GET['portfolio_featured'] ? '1' : '',
        ];
    }

    if ( ! empty( $_GET['portfolio_year'] ) ) {
        $meta_query[] = [
            'key'   => '_npe_project_year',
            'value' => absint( $_GET['portfolio_year'] ),
            'type'  => 'NUMERIC',
        ];
    }

    if ( ! empty( $meta_query ) ) {
        $query->set( 'meta_query', $meta_query );
    }
} );
