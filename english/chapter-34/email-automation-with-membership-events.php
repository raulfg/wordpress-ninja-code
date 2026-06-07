// Welcome email when membership is activated
add_action( 'mepr-event-transaction-completed', function( $event ): void {
    $transaction = $event->get_data();
    $user        = new MeprUser( $transaction->user_id );

    if ( 'MeprSubscription' !== $transaction->obj_type ) {
        return; // Only for new subscriptions
    }

    $subject = sprintf(
        __( 'Welcome to %s, %s', 'ninja-membership' ),
        get_bloginfo( 'name' ),
        $user->first_name
    );

    $body = ninja_render_email_template( 'welcome', [
        'first_name'     => $user->first_name,
        'plan_name'      => $transaction->membership()->post_title,
        'dashboard_url'  => get_permalink( get_option( 'ninja_dashboard_page_id' ) ),
        'support_email'  => get_option( 'ninja_support_email' ),
    ] );

    wp_mail( $user->user_email, $subject, $body, [
        'Content-Type: text/html; charset=UTF-8',
    ] );
} );

// Renewal reminder 7 days before expiry
add_action( 'ninja_membership_renewal_reminder', function( int $user_id, int $days_left ): void {
    $user = get_userdata( $user_id );

    if ( ! $user ) {
        return;
    }

    $subject = sprintf(
        __( 'Your membership renews in %d days', 'ninja-membership' ),
        $days_left
    );

    $body = ninja_render_email_template( 'renewal-reminder', [
        'first_name'    => $user->first_name,
        'days_left'     => $days_left,
        'billing_url'   => ninja_get_billing_portal_url( $user_id ),
    ] );

    wp_mail( $user->user_email, $subject, $body, [
        'Content-Type: text/html; charset=UTF-8',
    ] );
}, 10, 2 );
