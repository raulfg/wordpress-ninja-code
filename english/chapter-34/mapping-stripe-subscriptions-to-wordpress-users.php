function ninja_on_subscription_created( \Stripe\Subscription $subscription ): void {
    $stripe_customer_id = $subscription->customer;

    // Find the WordPress user with this customer ID
    $users = get_users( [
        'meta_key'   => '_ninja_stripe_customer_id',
        'meta_value' => $stripe_customer_id,
        'number'     => 1,
    ] );

    if ( empty( $users ) ) {
        // Customer ID does not exist in WordPress: possible configuration error
        error_log( "[NinjaTheme] Webhook subscription.created: no user found for customer {$stripe_customer_id}" );
        return;
    }

    $user_id = $users[0]->ID;
    $plan    = ninja_plan_from_stripe_price( $subscription->items->data[0]->price->id );

    ninja_activate_membership( $user_id, $plan );

    // Save the subscription ID for future cancellations and updates
    update_user_meta( $user_id, '_ninja_stripe_subscription_id', $subscription->id );
}

function ninja_on_subscription_deleted( \Stripe\Subscription $subscription ): void {
    $users = get_users( [
        'meta_key'   => '_ninja_stripe_subscription_id',
        'meta_value' => $subscription->id,
        'number'     => 1,
    ] );

    if ( ! empty( $users ) ) {
        ninja_deactivate_membership( $users[0]->ID );
    }
}
