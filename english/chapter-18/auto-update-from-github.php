add_filter( 'pre_set_site_transient_update_plugins', 'npe_check_for_update' );

function npe_check_for_update( object $transient ): object {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    $plugin_slug = plugin_basename( NPE_PLUGIN_FILE );

    // Only check if the update cache has expired
    $remote_info = get_transient( 'npe_remote_version_info' );

    if ( false === $remote_info ) {
        $response = wp_remote_get(
            'https://api.github.com/repos/raulfg/ninja-portfolio-enhancer/releases/latest',
            [
                'headers' => [
                    'Accept'     => 'application/vnd.github.v3+json',
                    'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ),
                ],
                'timeout' => 10,
            ]
        );

        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
            return $transient;
        }

        $remote_info = json_decode( wp_remote_retrieve_body( $response ) );
        set_transient( 'npe_remote_version_info', $remote_info, 12 * HOUR_IN_SECONDS );
    }

    $latest_version = ltrim( $remote_info->tag_name ?? '', 'v' );

    if ( version_compare( NPE_VERSION, $latest_version, '<' ) ) {
        $transient->response[ $plugin_slug ] = (object) [
            'slug'        => dirname( $plugin_slug ),
            'plugin'      => $plugin_slug,
            'new_version' => $latest_version,
            'url'         => $remote_info->html_url ?? '',
            'package'     => $remote_info->assets[0]->browser_download_url ?? '',
        ];
    }

    return $transient;
}
