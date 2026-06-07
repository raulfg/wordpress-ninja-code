<?php

$response = wp_remote_get( $url, $args );

if ( is_wp_error( $response ) ) {
    // Network failure: log the technical message, do not show it to the user
    error_log( '[my-plugin] Network error: ' . $response->get_error_message() );
    return $this->get_cached_fallback();
}

$code = wp_remote_retrieve_response_code( $response );

if ( $code >= 500 ) {
    // Remote server failure: likely transient
    error_log( sprintf( '[my-plugin] API server error %d for %s', $code, $url ) );
    return $this->get_cached_fallback();
}

if ( $code >= 400 ) {
    // Client error: check parameters, credentials, permissions
    error_log( sprintf( '[my-plugin] API client error %d: %s', $code, wp_remote_retrieve_body( $response ) ) );
    return null;
}
