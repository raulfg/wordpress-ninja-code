<?php

$response = wp_remote_get( 'https://api.example.com/v1/products' );

if ( is_wp_error( $response ) ) {
    error_log( 'API request failed: ' . $response->get_error_message() );
    return null;
}

$status_code = wp_remote_retrieve_response_code( $response );

if ( 200 !== $status_code ) {
    error_log( sprintf( 'Unexpected status %d from products API', $status_code ) );
    return null;
}

$body = wp_remote_retrieve_body( $response );
$data = json_decode( $body, true );
