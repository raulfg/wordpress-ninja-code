<?php

$state = wp_generate_password( 16, false );
set_transient( 'oauth_state_' . get_current_user_id(), $state, 300 );

$auth_url = add_query_arg(
    [
        'client_id'     => get_option( 'my_plugin_client_id' ),
        'redirect_uri'  => admin_url( 'admin.php?page=my-plugin-callback' ),
        'response_type' => 'code',
        'scope'         => 'read write',
        'state'         => $state,
    ],
    'https://provider.example.com/oauth/authorize'
);

wp_redirect( $auth_url );
exit;
