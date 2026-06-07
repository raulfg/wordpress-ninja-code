// Definir las capacidades de membresía
define( 'NINJA_CAP_MEMBER_BASIC',    'ninja_member_basic' );
define( 'NINJA_CAP_MEMBER_PRO',      'ninja_member_pro' );
define( 'NINJA_CAP_MEMBER_LIFETIME', 'ninja_member_lifetime' );

// Asignar capacidad al activar una membresía
function ninja_activate_membership( int $user_id, string $plan ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    // Eliminar membresías anteriores
    $user->remove_cap( NINJA_CAP_MEMBER_BASIC );
    $user->remove_cap( NINJA_CAP_MEMBER_PRO );

    // Añadir la nueva
    $cap = match ( $plan ) {
        'pro'      => NINJA_CAP_MEMBER_PRO,
        'lifetime' => NINJA_CAP_MEMBER_LIFETIME,
        default    => NINJA_CAP_MEMBER_BASIC,
    };

    $user->add_cap( $cap );

    // Guardar fecha de inicio y plan activo
    update_user_meta( $user_id, '_ninja_membership_start', current_time( 'mysql' ) );
    update_user_meta( $user_id, '_ninja_membership_plan', $plan );
    update_user_meta( $user_id, '_ninja_membership_expires', ninja_calculate_expiry( $plan ) );
}

// Revocar membresía (al expirar o cancelar)
function ninja_deactivate_membership( int $user_id ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    $user->remove_cap( NINJA_CAP_MEMBER_BASIC );
    $user->remove_cap( NINJA_CAP_MEMBER_PRO );
    $user->remove_cap( NINJA_CAP_MEMBER_LIFETIME );

    delete_user_meta( $user_id, '_ninja_membership_plan' );
}
