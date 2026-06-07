// Check whether content is available for the current user
function ninja_membership_content_available( int $post_id, int $user_id ): bool {
    $drip_days = (int) get_post_meta( $post_id, '_ninja_drip_days', true );

    // If no drip is configured, content is available immediately
    if ( ! $drip_days ) {
        return true;
    }

    // Get the user's membership start date
    $membership_start = get_user_meta( $user_id, '_ninja_membership_start', true );
    if ( ! $membership_start ) {
        return false;
    }

    $days_since_start = (int) floor(
        ( time() - strtotime( $membership_start ) ) / DAY_IN_SECONDS
    );

    return $days_since_start >= $drip_days;
}
