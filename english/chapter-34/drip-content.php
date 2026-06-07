/**
 * Returns true if the content is already available to the user.
 *
 * @param int $user_id
 * @param int $post_id
 * @param int $days_after_signup Days since membership start.
 */
function membership_content_is_available( int $user_id, int $post_id, int $days_after_signup ): bool {
    // Get the membership start date (depends on the plugin)
    $start_date = get_user_meta( $user_id, 'membership_start_date', true );

    if ( ! $start_date ) {
        return false;
    }

    $available_from = strtotime( $start_date ) + ( $days_after_signup * DAY_IN_SECONDS );

    return time() >= $available_from;
}
