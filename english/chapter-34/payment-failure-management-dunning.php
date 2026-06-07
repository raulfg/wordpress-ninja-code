function handle_payment_failed( \Stripe\Invoice $invoice ): void {
    $customer_id = $invoice->customer;
    $user_id     = get_user_id_by_stripe_customer( $customer_id );

    if ( ! $user_id ) {
        return;
    }

    $attempt_count = $invoice->attempt_count;

    if ( $attempt_count === 1 ) {
        // First failure: notify the user without revoking access
        send_payment_failed_email( $user_id, 'first_attempt' );
    } elseif ( $attempt_count >= 3 ) {
        // Third failed attempt: warn that access is at risk
        send_payment_failed_email( $user_id, 'final_warning' );
    }

    // Definitive revocation arrives with customer.subscription.deleted
    // when Stripe exhausts all retries — do not do it here
}
