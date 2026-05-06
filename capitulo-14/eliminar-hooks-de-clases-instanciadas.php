function remove_hook_from_object( string $hook, string $class, string $method, int $priority = 10 ): bool {
    global $wp_filter;

    if ( ! isset( $wp_filter[ $hook ][ $priority ] ) ) {
        return false;
    }

    foreach ( $wp_filter[ $hook ][ $priority ] as $key => $callback ) {
        if ( isset( $callback['function'] )
            && is_array( $callback['function'] )
            && $callback['function'][0] instanceof $class
            && $callback['function'][1] === $method ) {

            unset( $wp_filter[ $hook ][ $priority ][ $key ] );
            return true;
        }
    }

    return false;
}

// Uso
remove_hook_from_object( 'the_content', 'PluginA_Handler', 'modify_content' );
