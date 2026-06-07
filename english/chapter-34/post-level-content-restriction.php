add_filter( 'the_content', function( string $content ): string {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }

    if ( has_membership_access( get_the_ID(), get_current_user_id() ) ) {
        return $content;
    }

    $excerpt = get_the_excerpt();
    $notice  = '<div class="membership-required">'
        . '<p>' . $excerpt . '</p>'
        . '<p><a href="' . esc_url( get_membership_page_url() ) . '">Access with your membership to read the full article.</a></p>'
        . '</div>';

    return $notice;
} );
