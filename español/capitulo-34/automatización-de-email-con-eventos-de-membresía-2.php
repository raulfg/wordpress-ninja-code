add_action( 'mepr-event-transaction-completed', function( $event ): void {
    $transaction = $event->get_data();
    $expires     = strtotime( $transaction->expires_at );

    if ( ! $expires ) {
        return; // Suscripción sin expiración (renovación automática activa)
    }

    $reminder_time = $expires - ( 7 * DAY_IN_SECONDS );

    if ( $reminder_time > time() ) {
        wp_schedule_single_event(
            $reminder_time,
            'ninja_membership_renewal_reminder',
            [ $transaction->user_id, 7 ]
        );
    }
} );
