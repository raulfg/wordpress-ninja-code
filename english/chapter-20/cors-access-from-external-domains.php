// Restrict CORS to specific origins
add_filter( 'rest_allowed_cors_headers', function ( array $headers ): array {
    $headers[] = 'X-Custom-Header';
    return $headers;
} );

// Full control over the allowed origin
add_action( 'rest_api_init', function (): void {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    add_filter( 'rest_pre_serve_request', function ( bool $served ): bool {
        $allowed_origins = [
            'https://app.example.com',
            'https://staging.example.com',
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
