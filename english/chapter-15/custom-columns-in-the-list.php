add_filter( 'manage_portfolio_posts_columns', function( array $columns ): array {
    $new_columns = [];

    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;

        if ( 'title' === $key ) {
            $new_columns['thumbnail']     = __( 'Image', 'ninja-portfolio' );
            $new_columns['client']        = __( 'Client', 'ninja-portfolio' );
            $new_columns['year']          = __( 'Year', 'ninja-portfolio' );
            $new_columns['featured']      = __( 'Featured', 'ninja-portfolio' );
            $new_columns['portfolio_cat'] = __( 'Category', 'ninja-portfolio' );
        }
    }

    unset( $new_columns['author'] );

    return $new_columns;
} );
