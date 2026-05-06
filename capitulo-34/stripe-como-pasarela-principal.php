// Verificar y parsear un webhook de Stripe
add_action( 'init', function() {
    if ( ! isset( $_SERVER['REQUEST_URI'] ) || strpos( $_SERVER['REQUEST_URI'], '/webhook/stripe' ) === false ) {
        return;
    }

    $payload   = file_get_contents( 'php://input' );
    $sig       = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
    $secret    = defined( 'STRIPE_WEBHOOK_SECRET' ) ? STRIPE_WEBHOOK_SECRET : '';

    try {
        $event = \Stripe\Webhook::constructEvent( $payload, $sig, $secret );
    } catch ( \UnexpectedValueException | \Stripe\Exception\SignatureVerificationException $e ) {
        http_response_code( 400 );
        exit;
    }

    match ( $event->type ) {
        'invoice.paid'                    => handle_subscription_renewed( $event->data->object ),
        'invoice.payment_failed'          => handle_payment_failed( $event->data->object ),
        'customer.subscription.deleted'   => handle_subscription_cancelled( $event->data->object ),
        default                           => null,
    };

    http_response_code( 200 );
    exit;
} );
