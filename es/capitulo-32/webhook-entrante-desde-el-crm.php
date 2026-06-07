add_action( 'rest_api_init', function(): void {
    register_rest_route( 'ninja-portfolio/v1', '/webhooks/hubspot', [
        'methods'             => 'POST',
        'callback'            => 'ninja_handle_hubspot_webhook',
        'permission_callback' => 'ninja_verify_hubspot_signature',
    ] );
} );

function ninja_verify_hubspot_signature( WP_REST_Request $request ): bool {
    $secret    = get_option( 'ninja_hubspot_webhook_secret', '' );
    $body      = $request->get_body();
    $signature = $request->get_header( 'X-HubSpot-Signature' );

    if ( empty( $secret ) || empty( $signature ) ) {
        return false;
    }

    $expected = hash_hmac( 'sha256', $body, $secret );

    return hash_equals( $expected, $signature );
}

function ninja_handle_hubspot_webhook( WP_REST_Request $request ): WP_REST_Response {
    $events = $request->get_json_params();

    foreach ( (array) $events as $event ) {
        $object_type  = $event['subscriptionType'] ?? '';
        $contact_id   = $event['objectId'] ?? 0;
        $property     = $event['propertyName'] ?? '';
        $new_value    = $event['propertyValue'] ?? '';

        if ( 'contact.propertyChange' !== $object_type ) {
            continue;
        }

        if ( 'lifecyclestage' !== $property || 'customer' !== $new_value ) {
            continue;
        }

        // Buscar el usuario de WordPress con este ID de HubSpot
        $users = get_users( [
            'meta_key'   => '_hubspot_contact_id',
            'meta_value' => (string) $contact_id,
            'number'     => 1,
        ] );

        if ( empty( $users ) ) {
            continue;
        }

        // Marcar al usuario como cliente en WordPress
        $user = $users[0];
        $user->add_role( 'ninja_client' );
        update_user_meta( $user->ID, '_became_customer_at', current_time( 'mysql' ) );
    }

    return new WP_REST_Response( [ 'processed' => true ], 200 );
}
