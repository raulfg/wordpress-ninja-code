function ninja_get_billing_portal_url( int $user_id ): string {
    $stripe_customer_id = get_user_meta( $user_id, '_stripe_customer_id', true );

    if ( ! $stripe_customer_id ) {
        return get_permalink( get_option( 'ninja_plans_page_id' ) );
    }

    \Stripe\Stripe::setApiKey( get_option( 'ninja_stripe_secret_key' ) );

    try {
        $session = \Stripe\BillingPortal\Session::create( [
            'customer'   => $stripe_customer_id,
            'return_url' => get_permalink(),
        ] );
        return $session->url;
    } catch ( \Stripe\Exception\ApiErrorException $e ) {
        error_log( '[ninja-membership] Stripe portal error: ' . $e->getMessage() );
        return get_permalink();
    }
}
