<?php

function my_plugin_api_get_with_retry( string $url, array $args = [], int $max_attempts = 3 ): ?array
{
    $attempt = 0;

    while ( $attempt < $max_attempts ) {
        $response = wp_remote_get( $url, $args );

        if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
            return json_decode( wp_remote_retrieve_body( $response ), true );
        }

        $attempt++;

        if ( $attempt < $max_attempts ) {
            // Exponential backoff: 1s, 2s, 4s
            sleep( (int) pow( 2, $attempt - 1 ) );
        }
    }

    return null;
}
