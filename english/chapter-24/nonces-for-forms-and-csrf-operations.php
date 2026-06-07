add_action( 'admin_post_ninja_guardar_configuracion', 'ninja_procesar_configuracion' );

function ninja_procesar_configuracion(): void {
    // Verify nonce — wp_die if it fails
    if ( ! isset( $_POST['ninja_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ninja_nonce'], 'ninja_guardar_configuracion' ) ) {
        wp_die( esc_html__( 'Security error. Please reload the page and try again.', 'ninjatheme' ) );
    }

    // Check user permissions
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to perform this action.', 'ninjatheme' ) );
    }

    // Sanitize and save
    $api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';
    update_option( 'ninja_api_key', $api_key );

    // Redirect with success message
    wp_redirect( add_query_arg( 'updated', '1', wp_get_referer() ) );
    exit;
}
