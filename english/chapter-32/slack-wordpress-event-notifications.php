<?php

function my_plugin_notify_slack( string $message, string $channel = '#orders' ): bool
{
    $webhook_url = get_option( 'my_plugin_slack_webhook_url' );

    if ( empty( $webhook_url ) ) {
        return false;
    }

    $response = wp_remote_post(
        $webhook_url,
        [
            'timeout'     => 10,
            'headers'     => [ 'Content-Type' => 'application/json' ],
            'body'        => wp_json_encode(
                [
                    'channel' => $channel,
                    'text'    => $message,
                ]
            ),
        ]
    );

    return ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response );
}

// Notify when a WooCommerce order is completed
add_action( 'woocommerce_order_status_completed', function ( int $order_id ): void {
    $order   = wc_get_order( $order_id );
    $message = sprintf(
        'Order #%d completed — %s — %s',
        $order_id,
        $order->get_formatted_billing_full_name(),
        wc_price( $order->get_total() )
    );

    my_plugin_notify_slack( $message );
} );
