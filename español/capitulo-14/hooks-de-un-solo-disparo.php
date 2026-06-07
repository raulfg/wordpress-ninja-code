function ninja_add_once( string $hook, callable $callback, int $priority = 10 ): void {
    $wrapper = null;
    $wrapper = function() use ( $hook, $callback, &$wrapper, $priority ): mixed {
        remove_action( $hook, $wrapper, $priority );
        return call_user_func_array( $callback, func_get_args() );
    };

    add_action( $hook, $wrapper, $priority );
}

// Uso: ejecutar solo la primera vez que se cargue la plantilla de portfolio
ninja_add_once( 'template_redirect', function(): void {
    if ( is_singular( 'portfolio' ) ) {
        // Esta lógica se ejecuta solo en el primer request de portfolio
        do_action( 'npe_first_portfolio_view', get_queried_object_id() );
    }
} );
