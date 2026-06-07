register_rest_route(
    'ninjatheme/v1',
    '/contact',
    [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ninjatheme_handle_contact',
        'permission_callback' => '__return_true',
        'args'                => [
            'name' => [
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'email' => [
                'required'          => true,
                'validate_callback' => fn( $v ) => is_email( $v ),
                'sanitize_callback' => 'sanitize_email',
            ],
            'message' => [
                'required'          => true,
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
        ],
    ]
);

function ninjatheme_handle_contact( WP_REST_Request $request ): WP_REST_Response|WP_Error {
    // get_param() returns values ALREADY processed by sanitize_callback in args.
    // Do not call get_json_params() here: that returns the raw body, bypassing args.
    $name    = $request->get_param( 'name' );
    $email   = $request->get_param( 'email' );
    $message = $request->get_param( 'message' );

    $post_id = wp_insert_post( [
        'post_type'    => 'contact_submission',
        'post_status'  => 'private',
        'post_title'   => $name,
        'meta_input'   => [
            'contact_email'   => $email,
            'contact_message' => $message,
        ],
    ] );

    if ( is_wp_error( $post_id ) ) {
        return new WP_Error(
            'contact_save_failed',
            'Could not save the message.',
            [ 'status' => 500 ]
        );
    }

    return new WP_REST_Response( [ 'id' => $post_id ], 201 );
}
