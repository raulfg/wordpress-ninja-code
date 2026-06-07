// Restringir CORS a orígenes específicos
add_filter( 'rest_allowed_cors_headers', function ( array $headers ): array {
    $headers[] = 'X-Custom-Header';
    return $headers;
} );

// Control completo sobre el origen permitido
add_action( 'rest_api_init', function (): void {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    add_filter( 'rest_pre_serve_request', function ( bool $served ): bool {
        $allowed_origins = [
            'https://app.ejemplo.com',
            'https://staging.ejemplo.com',
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if ( in_array( $origin, $allowed_origins, true ) ) {
            header( 'Access-Control-Allow-Origin: ' . $origin );
            header( 'Access-Control-Allow-Credentials: true' );
            header( 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS' );
            header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce' );
        }

        return $served;
    } );
}, 15 );
