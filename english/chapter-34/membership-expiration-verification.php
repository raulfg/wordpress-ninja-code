// Schedule the daily check if not already scheduled
if ( ! wp_next_scheduled( 'ninja_check_membership_expirations' ) ) {
    wp_schedule_event( time(), 'daily', 'ninja_check_membership_expirations' );
}

add_action( 'ninja_check_membership_expirations', function(): void {
    $users_with_membership = get_users( [
        'meta_key'     => '_ninja_membership_expires',
        'meta_compare' => 'EXISTS',
        'number'       => -1,
    ] );

    foreach ( $users_with_membership as $user ) {
        $expires = get_user_meta( $user->ID, '_ninja_membership_expires', true );

        if ( ! $expires ) {
            continue;
        }

        // If the membership has already expired
        if ( strtotime( $expires ) < time() ) {
            ninja_deactivate_membership( $user->ID );

            // Notify the user
            wp_mail(
                $user->user_email,
                __( 'Your membership has expired', 'ninjatheme' ),
                sprintf(
                    __( 'Hi %s, your membership has expired. Renew it to keep accessing premium content.', 'ninjatheme' ),
                    $user->display_name
                )
            );
        }

        // Advance notice: if it expires in less than 7 days and no notice has been sent
        $days_to_expiry = (int) ceil( ( strtotime( $expires ) - time() ) / DAY_IN_SECONDS );
        $notice_sent    = get_user_meta( $user->ID, '_ninja_expiry_notice_sent', true );

        if ( $days_to_expiry <= 7 && $days_to_expiry > 0 && ! $notice_sent ) {
            wp_mail(
                $user->user_email,
                __( 'Your membership is expiring soon', 'ninjatheme' ),
                sprintf(
                    __( 'Your membership expires in %d days. Renew it to keep your access.', 'ninjatheme' ),
                    $days_to_expiry
                )
            );
            update_user_meta( $user->ID, '_ninja_expiry_notice_sent', '1' );
        }
    }
} );
