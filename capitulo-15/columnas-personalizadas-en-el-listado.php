add_filter( 'manage_portfolio_posts_columns', function( array $columns ): array {
    $new_columns = [];

    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;

        if ( 'title' === $key ) {
            $new_columns['thumbnail']     = __( 'Imagen', 'ninja-portfolio' );
            $new_columns['client']        = __( 'Cliente', 'ninja-portfolio' );
            $new_columns['year']          = __( 'Año', 'ninja-portfolio' );
            $new_columns['featured']      = __( 'Destacado', 'ninja-portfolio' );
            $new_columns['portfolio_cat'] = __( 'Categoría', 'ninja-portfolio' );
        }
    }

    unset( $new_columns['author'] );

    return $new_columns;
} );
