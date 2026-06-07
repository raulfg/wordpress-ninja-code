// Cancel at the end of the current period (recommended)
function cancel_membership_at_period_end( int $user_id ): bool {
    $subscription_id = get_user_meta( $user_id, 'stripe_subscription_id', true );

    if ( ! $subscription_id ) {
        return false;
    }

    $subscription = \Stripe\Subscription::update( $subscription_id, [
        'cancel_at_period_end' => true,
    ] );

    // Mark in WordPress that cancellation is pending
    update_user_meta( $user_id, 'membership_cancelling', true );

    // The actual revocation arrives when Stripe sends customer.subscription.deleted
    return true;
}
