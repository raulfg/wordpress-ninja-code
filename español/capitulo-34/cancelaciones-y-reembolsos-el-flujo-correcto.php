// Cancelar al final del período actual (recomendado)
function cancel_membership_at_period_end( int $user_id ): bool {
    $subscription_id = get_user_meta( $user_id, 'stripe_subscription_id', true );

    if ( ! $subscription_id ) {
        return false;
    }

    $subscription = \Stripe\Subscription::update( $subscription_id, [
        'cancel_at_period_end' => true,
    ] );

    // Marcar en WordPress que la cancelación está pendiente
    update_user_meta( $user_id, 'membership_cancelling', true );

    // La revocación real llega cuando Stripe envía customer.subscription.deleted
    return true;
}
