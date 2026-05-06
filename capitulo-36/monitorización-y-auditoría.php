add_action( 'wp_ability_before_execute', function( string $name, array $args, int $user_id ): void {
    // Logging de todas las ejecuciones en producción
    if ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'production' === WP_ENVIRONMENT_TYPE ) {
        error_log( sprintf(
            '[abilities] executing=%s user=%d timestamp=%s',
            $name,
            $user_id,
            current_time( 'c' )
        ) );
    }
}, 10, 3 );

add_action( 'wp_ability_execution_error', function( string $name, \WP_Error $error, int $user_id ): void {
    error_log( sprintf(
        '[abilities] error=%s ability=%s user=%d message=%s',
        $error->get_error_code(),
        $name,
        $user_id,
        $error->get_error_message()
    ) );
}, 10, 3 );
