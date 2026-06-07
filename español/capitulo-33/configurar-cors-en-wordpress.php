add_filter( 'rest_allowed_cors_headers', function ( array $headers ): array {
    $headers[] = 'X-WP-Nonce';
    return $headers;
} );

add_filter( 'rest_pre_serve_request', function ( bool $served, \WP_HTTP_Response $result ): bool {
    $origin = get_http_origin();
    $allowed = [
        'https://www.tudominio.com',
        'https://staging.tudominio.com',
    ];

    if ( in_array( $origin, $allowed, true ) ) {
        header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Vary: Origin' );
        // Sin Expose-Headers, el navegador bloquea la lectura de X-WP-Total
        // y X-WP-TotalPages desde JavaScript aunque el servidor los envíe.
        header( 'Access-Control-Expose-Headers: X-WP-Total, X-WP-TotalPages, Link' );
    }

    return $served;
}, 10, 2 );
