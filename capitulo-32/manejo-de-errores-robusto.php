$response = wp_remote_get( $url, $args );

if ( is_wp_error( $response ) ) {
    // Fallo de red: loguear el mensaje técnico, no mostrarlo al usuario
    error_log( '[mi-plugin] Network error: ' . $response->get_error_message() );
    return $this->get_cached_fallback();
}

$code = wp_remote_retrieve_response_code( $response );

if ( $code >= 500 ) {
    // Fallo del servidor remoto: probablemente transitorio
    error_log( sprintf( '[mi-plugin] API server error %d for %s', $code, $url ) );
    return $this->get_cached_fallback();
}

if ( $code >= 400 ) {
    // Error de cliente: revisar parámetros, credenciales, permisos
    error_log( sprintf( '[mi-plugin] API client error %d: %s', $code, wp_remote_retrieve_body( $response ) ) );
    return null;
}
