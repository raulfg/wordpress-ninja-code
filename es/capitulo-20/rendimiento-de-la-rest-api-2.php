add_filter(
    'rest_post_dispatch',
    function (
        WP_REST_Response $response,
        WP_REST_Server $server,
        WP_REST_Request $request
    ) {
        $route = $request->get_route();

        if ( 'GET' === $request->get_method()
            && preg_match( '#^/wp/v2/portfolio#', $route )
            && 200 === $response->get_status() ) {

            $response->header( 'Cache-Control', 'public, max-age=300, stale-while-revalidate=60' );
            $response->header( 'Vary', 'Accept' );
        }

        return $response;
    },
    10,
    3
);
