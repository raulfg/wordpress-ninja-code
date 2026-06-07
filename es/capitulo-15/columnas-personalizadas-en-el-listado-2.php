add_action(
    'manage_portfolio_posts_custom_column',
    function( string $column, int $post_id ): void {
        switch ( $column ) {
            case 'thumbnail':
                $thumb = get_the_post_thumbnail( $post_id, [ 60, 60 ] );
                echo $thumb ?: '—';
                break;

            case 'client':
                $client = get_post_meta( $post_id, '_npe_client_name', true );
                echo $client
                    ? esc_html( $client )
                    : '<span class="description">—</span>';
                // Div oculto para el quick edit
                printf(
                    '<div class="hidden" id="portfolio_inline_%d">'
                    . '<div class="portfolio_client">%s</div>'
                    . '<div class="portfolio_featured">%s</div>'
                    . '</div>',
                    $post_id,
                    esc_html( $client ),
                    esc_html( get_post_meta( $post_id, '_npe_is_featured', true ) ? '1' : '0' )
                );
                break;

            case 'year':
                $year = get_post_meta( $post_id, '_npe_project_year', true );
                echo $year
                    ? esc_html( $year )
                    : '<span class="description">—</span>';
                break;

            case 'featured':
                $is_featured = get_post_meta( $post_id, '_npe_is_featured', true );
                echo $is_featured
                    ? '<span class="dashicons dashicons-star-filled"'
                        . ' style="color:#f0b429;" title="Destacado"></span>'
                    : '<span class="dashicons dashicons-star-empty"'
                        . ' style="color:#ccc;" title="No destacado"></span>';
                break;

            case 'portfolio_cat':
                $terms = get_the_terms( $post_id, 'portfolio-category' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    $links = array_map( function( \WP_Term $term ): string {
                        $url = add_query_arg( [
                            'post_type'          => 'portfolio',
                            'portfolio-category' => $term->slug,
                        ], admin_url( 'edit.php' ) );
                        return '<a href="' . esc_url( $url ) . '">'
                            . esc_html( $term->name ) . '</a>';
                    }, $terms );
                    echo implode( ', ', $links );
                } else {
                    echo '—';
                }
                break;
        }
    },
    10,
    2
);
