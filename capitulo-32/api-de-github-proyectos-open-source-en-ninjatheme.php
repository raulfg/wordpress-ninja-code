function ninjatheme_get_github_repos( string $username ): array
{
    $cache_key = 'ninja_github_repos_' . sanitize_key( $username );
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return $cached;
    }

    $response = wp_remote_get(
        "https://api.github.com/users/{$username}/repos?sort=updated&per_page=6",
        [
            'timeout' => 10,
            'headers' => [
                'Accept'     => 'application/vnd.github.v3+json',
                'User-Agent' => 'NinjaTheme/1.0 (+' . home_url() . ')',
            ],
        ]
    );

    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return [];
    }

    $repos = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( ! is_array( $repos ) ) {
        return [];
    }

    // Solo los campos que necesita la plantilla
    $repos = array_map( fn( $repo ) => [
        'name'        => $repo['name'],
        'description' => $repo['description'] ?? '',
        'url'         => $repo['html_url'],
        'stars'       => $repo['stargazers_count'],
        'language'    => $repo['language'],
    ], $repos );

    // Caché de 1 hora — GitHub limita a 60 peticiones/hora sin autenticación
    set_transient( $cache_key, $repos, HOUR_IN_SECONDS );

    return $repos;
}
