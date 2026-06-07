$result = my_plugin_get_user( $user_id );

if ( is_wp_error( $result ) ) {
    // Log the technical error
    error_log(
        sprintf(
            '[my-plugin] %s: %s',
            $result->get_error_code(),
            $result->get_error_message()
        )
    );

    // Display message to the user if appropriate
    echo '<p class="error">' . esc_html( $result->get_error_message() ) . '</p>';
    return;
}

// Here $result is WP_User safely
