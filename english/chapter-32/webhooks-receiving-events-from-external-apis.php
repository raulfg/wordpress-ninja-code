<?php

add_action( 'rest_api_init', function(): void {
    register_rest_route( 'ninja/v1', '/webhook/stripe', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ninja_handle_stripe_webhook',
        'permission_callback' => '__return_true',
    ] );
} );

function ninja_handle_stripe_webhook( WP_REST_Request $request ): WP_REST_Response|WP_Error {
    // 1. Verify the webhook signature
    $payload   = $request->get_body();
    $sig_header = $request->get_header( 'stripe-signature' );
    $secret     = get_option( 'ninja_stripe_webhook_secret' );

    try {
        $event = \Stripe\Webhook::constructEvent( $payload, $sig_header, $secret );
    } catch ( \Stripe\Exception\SignatureVerificationException $e ) {
        return new WP_Error( 'invalid_signature', 'Invalid webhook signature.', [ 'status' => 400 ] );
    }

    // 2. Process the event based on its type
    switch ( $event->type ) {
        case 'payment_intent.succeeded':
            ninja_process_successful_payment( $event->data->object );
            break;

        case 'customer.subscription.deleted':
            ninja_handle_subscription_cancellation( $event->data->object );
            break;
    }

    // 3. Respond immediately with 200
    // Stripe retries if it does not receive a 200 within 30 seconds
    return new WP_REST_Response( [ 'received' => true ], 200 );
}
