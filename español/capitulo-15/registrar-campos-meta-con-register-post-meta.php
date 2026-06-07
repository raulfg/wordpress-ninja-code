add_action( 'init', function (): void {
    register_post_meta( 'portfolio', '_npe_project_url', [
        'type'         => 'string',
        'description'  => 'URL del proyecto en producción',
        'single'       => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'esc_url_raw',
        'auth_callback' => function () {
            return current_user_can( 'edit_posts' );
        },
    ] );

    register_post_meta( 'portfolio', '_npe_client_name', [
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function () {
            return current_user_can( 'edit_posts' );
        },
    ] );

    register_post_meta( 'portfolio', '_npe_project_year', [
        'type'         => 'integer',
        'single'       => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'auth_callback' => function () {
            return current_user_can( 'edit_posts' );
        },
    ] );
} );
