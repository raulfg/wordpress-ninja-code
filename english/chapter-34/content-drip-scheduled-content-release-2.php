if ( is_singular() && is_user_logged_in() ) {
    $post_id = get_the_ID();
    $user_id = get_current_user_id();

    if ( ! ninja_membership_content_available( $post_id, $user_id ) ) {
        $drip_days     = (int) get_post_meta( $post_id, '_ninja_drip_days', true );
        $membership_start = get_user_meta( $user_id, '_ninja_membership_start', true );
        $unlock_date   = date_i18n(
            get_option( 'date_format' ),
            strtotime( $membership_start ) + ( $drip_days * DAY_IN_SECONDS )
        );

        // Show message instead of content
        echo '<div class="drip-notice">';
        printf(
            esc_html__( 'This content will be available to you from %s.', 'ninjatheme' ),
            '<strong>' . esc_html( $unlock_date ) . '</strong>'
        );
        echo '</div>';
        return; // Do not show the_content()
    }
}
