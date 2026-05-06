// Programar la verificación diaria si no está programada
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

        // Si la membresía ya venció
        if ( strtotime( $expires ) < time() ) {
            ninja_deactivate_membership( $user->ID );

            // Notificar al usuario
            wp_mail(
                $user->user_email,
                __( 'Tu membresía ha expirado', 'ninjatheme' ),
                sprintf(
                    __( 'Hola %s, tu membresía ha expirado. Renuévala para seguir accediendo al contenido premium.', 'ninjatheme' ),
                    $user->display_name
                )
            );
        }

        // Aviso previo: si expira en menos de 7 días y no se ha enviado aviso
        $days_to_expiry = (int) ceil( ( strtotime( $expires ) - time() ) / DAY_IN_SECONDS );
        $notice_sent    = get_user_meta( $user->ID, '_ninja_expiry_notice_sent', true );

        if ( $days_to_expiry <= 7 && $days_to_expiry > 0 && ! $notice_sent ) {
            wp_mail(
                $user->user_email,
                __( 'Tu membresía expira pronto', 'ninjatheme' ),
                sprintf(
                    __( 'Tu membresía expira en %d días. Renuévala para no perder acceso.', 'ninjatheme' ),
                    $days_to_expiry
                )
            );
            update_user_meta( $user->ID, '_ninja_expiry_notice_sent', '1' );
        }
    }
} );
