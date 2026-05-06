add_filter(
    'rest_pre_dispatch',
    function (
        $result,
        WP_REST_Server $server,
        WP_REST_Request $request
    ) {
        if ( 'GET' !== $request->get_method() ) {
            return $result;
        }

        $route = $request->get_route();

        if ( ! preg_match( '#^/wp/v2/portfolio#', $route ) ) {
            return $result;
        }

        $params    = serialize( $request->get_query_params() );
        $cache_key = 'rest_' . md5( $route . $params );
        $cached    = get_transient( $cache_key );

        if ( false !== $cached ) {
            return new WP_REST_Response( $cached, 200 );
        }

        return $result;
    },
    10,
    3
);

add_filter(
    'rest_post_dispatch',
    function (
        WP_REST_Response $response,
        WP_REST_Server $server,
        WP_REST_Request $request
    ) {
        if ( 'GET' !== $request->get_method() ) {
            return $response;
        }

        $route = $request->get_route();

        if ( ! preg_match( '#^/wp/v2/portfolio#', $route ) ) {
            return $response;
        }

        if ( 200 === $response->get_status() ) {
            $params    = serialize( $request->get_query_params() );
            $cache_key = 'rest_' . md5( $route . $params );
            set_transient( $cache_key, $response->get_data(), 5 * MINUTE_IN_SECONDS );
        }

        return $response;
    },
    10,
    3
);
