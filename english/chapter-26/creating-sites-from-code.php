$site_id = wp_insert_site( [
    'domain'     => 'new-site.domain.com', // for subdomains
    'path'       => '/',
    'blog_name'  => 'Site Name',
    'user_id'    => $admin_user_id,
    'site_id'    => get_current_network_id(),
    'options'    => [
        'admin_email'         => 'admin@new-site.com',
        'blogdescription'     => 'Brief site description.',
        'template'            => 'ninjatheme',
        'stylesheet'          => 'ninjatheme',
    ],
] );

if ( is_wp_error( $site_id ) ) {
    error_log( 'Error creating site: ' . $site_id->get_error_message() );
} else {
    // Site created successfully
    switch_to_blog( $site_id );
    // Additional configuration for the new site
    update_option( 'ninja_theme_options', $default_config );
    restore_current_blog();
}
