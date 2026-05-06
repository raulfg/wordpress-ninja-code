function handle_payment_failed( \Stripe\Invoice $invoice ): void {
    $customer_id = $invoice->customer;
    $user_id     = get_user_id_by_stripe_customer( $customer_id );

    if ( ! $user_id ) {
        return;
    }

    $attempt_count = $invoice->attempt_count;

    if ( $attempt_count === 1 ) {
        // Primer fallo: notificar al usuario sin revocar acceso
        send_payment_failed_email( $user_id, 'first_attempt' );
    } elseif ( $attempt_count >= 3 ) {
        // Tercer intento fallido: avisar que el acceso está en riesgo
        send_payment_failed_email( $user_id, 'final_warning' );
    }

    // La revocación definitiva llega con customer.subscription.deleted
    // cuando Stripe agota todos los reintentos — no la hagas aquí
}
