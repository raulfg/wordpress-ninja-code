/**
 * Devuelve true si el contenido ya está disponible para el usuario.
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $days_after_signup Días desde el inicio de la membresía.
 */
function membership_content_is_available( int $user_id, int $post_id, int $days_after_signup ): bool {
    // Obtener la fecha de inicio de la membresía (depende del plugin)
    $start_date = get_user_meta( $user_id, 'membership_start_date', true );

    if ( ! $start_date ) {
        return false;
    }

    $available_from = strtotime( $start_date ) + ( $days_after_signup * DAY_IN_SECONDS );

    return time() >= $available_from;
}
