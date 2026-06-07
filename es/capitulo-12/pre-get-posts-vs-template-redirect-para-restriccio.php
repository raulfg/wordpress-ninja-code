// Correcto: usar template_redirect para restricciones de acceso
add_action( 'template_redirect', function(): void {
    if ( is_singular( 'portfolio' ) && ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink() ) );
        exit;
    }
} );

// Incorrecto: usar pre_get_posts para restricciones de acceso
// (el post sigue siendo accesible directamente por URL)
add_action( 'pre_get_posts', function( WP_Query $query ): void {
    if ( $query->is_singular( 'portfolio' ) && ! is_user_logged_in() ) {
        // Esto solo excluye el post del loop, no restringe el acceso
        $query->set( 'post__not_in', [ get_queried_object_id() ] );
    }
} );
