add_filter( 'rest_allowed_cors_headers', 'ninja_cors_headers' );

function ninja_cors_headers( array $allow_headers ): array {
    $allow_headers[] = 'X-WP-Nonce';
    return $allow_headers;
}

add_action( 'rest_api_init', 'ninja_configurar_cors' );

function ninja_configurar_cors(): void {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    add_filter( 'rest_pre_serve_request', function ( $served ) {
        $origin = get_http_origin();
        $permitidos = [
            'https://app.ejemplo.com',
            'https://staging.ejemplo.com',
        ];

        if ( in_array( $origin, $permitidos, true ) ) {
            header( 'Access-Control-Allow-Origin: ' . $origin );
            header( 'Access-Control-Allow-Credentials: true' );
            header( 'Access-Control-Allow-Headers: X-WP-Nonce, Content-Type' );
        }

        return $served;
    } );
}
