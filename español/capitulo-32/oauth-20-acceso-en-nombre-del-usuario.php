$state = wp_generate_password( 16, false );
set_transient( 'oauth_state_' . get_current_user_id(), $state, 300 );

$auth_url = add_query_arg(
    [
        'client_id'     => get_option( 'mi_plugin_client_id' ),
        'redirect_uri'  => admin_url( 'admin.php?page=mi-plugin-callback' ),
        'response_type' => 'code',
        'scope'         => 'read write',
        'state'         => $state,
    ],
    'https://proveedor.example.com/oauth/authorize'
);

wp_redirect( $auth_url );
exit;
