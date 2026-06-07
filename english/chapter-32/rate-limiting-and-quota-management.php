<?php

function ninja_api_request( string $endpoint, array $args = [] ): array|WP_Error {
    // Check whether we are in a forced wait period
    $retry_after = get_transient( 'ninja_api_retry_after' );
    if ( $retry_after ) {
        return new WP_Error(
            'rate_limit',
            sprintf( 'API rate limit active. Retry after: %s', $retry_after ),
            [ 'status' => 429 ]
        );
    }

    $response = wp_remote_get(
        'https://api.service.com' . $endpoint,
        array_merge( [
            'timeout' => 10,
            'headers' => [
                'Authorization' => 'Bearer ' . get_option( 'ninja_api_token' ),
            ],
        ], $args )
    );

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $status_code = wp_remote_retrieve_response_code( $response );

    // If we receive a 429, store the wait time in a transient
    if ( 429 === $status_code ) {
        $retry_after_header = wp_remote_retrieve_header( $response, 'retry-after' );
        $wait_seconds = is_numeric( $retry_after_header )
            ? (int) $retry_after_header
            : strtotime( $retry_after_header ) - time();

        $wait_seconds = max( 60, min( 3600, $wait_seconds ) ); // between 1 min and 1 hour

        set_transient( 'ninja_api_retry_after', date( 'H:i:s', time() + $wait_seconds ), $wait_seconds );

        return new WP_Error( 'rate_limit', 'Request limit reached.', [ 'status' => 429 ] );
    }

    if ( $status_code >= 400 ) {
        return new WP_Error(
            'api_error',
            wp_remote_retrieve_response_message( $response ),
            [ 'status' => $status_code ]
        );
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    // Update the remaining quota if available
    $remaining = wp_remote_retrieve_header( $response, 'x-ratelimit-remaining' );
    if ( $remaining !== '' ) {
        update_option( 'ninja_api_rate_limit_remaining', (int) $remaining );
    }

    return $body ?: [];
}
