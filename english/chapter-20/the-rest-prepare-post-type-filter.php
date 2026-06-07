add_filter( 'rest_prepare_portfolio', 'ninjatheme_filter_portfolio_response', 10, 3 );

function ninjatheme_filter_portfolio_response(
    WP_REST_Response $response,
    WP_Post $post,
    WP_REST_Request $request
): WP_REST_Response {
    $data = $response->get_data();

    // Remove fields that should not be public
    unset( $data['guid'], $data['comment_status'], $data['ping_status'] );

    // Add computed data
    $data['reading_time'] = ninjatheme_estimate_reading_time( $post->post_content );

    $response->set_data( $data );

    return $response;
}
