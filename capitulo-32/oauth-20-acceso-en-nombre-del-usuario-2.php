$response = wp_remote_post(
    'https://proveedor.example.com/oauth/token',
    [
        'timeout' => 15,
        'body'    => [
            'grant_type'    => 'authorization_code',
            'code'          => sanitize_text_field( $_GET['code'] ),
            'redirect_uri'  => admin_url( 'admin.php?page=mi-plugin-callback' ),
            'client_id'     => get_option( 'mi_plugin_client_id' ),
            'client_secret' => get_option( 'mi_plugin_client_secret' ),
        ],
    ]
);

$token_data = json_decode( wp_remote_retrieve_body( $response ), true );
$access_token  = $token_data['access_token'];
$refresh_token = $token_data['refresh_token'] ?? null;
$expires_in    = $token_data['expires_in'] ?? 3600;

update_user_meta( get_current_user_id(), 'mi_plugin_access_token', $access_token );
update_user_meta( get_current_user_id(), 'mi_plugin_token_expiry', time() + $expires_in );
