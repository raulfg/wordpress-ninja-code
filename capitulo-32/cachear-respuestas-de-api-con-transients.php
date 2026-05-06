function mi_plugin_get_products(): ?array
{
    $cache_key = 'mi_plugin_products_v1';
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return $cached;
    }

    $response = wp_remote_get(
        'https://api.example.com/v1/products',
        [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . get_option( 'mi_plugin_api_key' ),
            ],
        ]
    );

    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return null;
    }

    $data = json_decode( wp_remote_retrieve_body( $response ), true );

    set_transient( $cache_key, $data, HOUR_IN_SECONDS );

    return $data;
}
