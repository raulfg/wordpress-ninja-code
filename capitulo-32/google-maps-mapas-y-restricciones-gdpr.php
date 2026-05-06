function mi_plugin_enqueue_maps(): void
{
    $api_key = get_option( 'mi_plugin_google_maps_key' );

    if ( empty( $api_key ) ) {
        return;
    }

    wp_enqueue_script(
        'google-maps',
        'https://maps.googleapis.com/maps/api/js?key=' . urlencode( $api_key ) . '&callback=miPluginInitMap',
        [],
        null,
        true
    );
}
