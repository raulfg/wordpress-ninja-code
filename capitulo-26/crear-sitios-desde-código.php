$site_id = wp_insert_site( [
    'domain'     => 'nuevo-sitio.dominio.com', // para subdominios
    'path'       => '/',
    'blog_name'  => 'Nombre del sitio',
    'user_id'    => $admin_user_id,
    'site_id'    => get_current_network_id(),
    'options'    => [
        'admin_email'         => 'admin@nuevo-sitio.com',
        'blogdescription'     => 'Descripción breve del sitio.',
        'template'            => 'ninjatheme',
        'stylesheet'          => 'ninjatheme',
    ],
] );

if ( is_wp_error( $site_id ) ) {
    error_log( 'Error creando sitio: ' . $site_id->get_error_message() );
} else {
    // Sitio creado correctamente
    switch_to_blog( $site_id );
    // Configuración adicional del sitio nuevo
    update_option( 'ninja_theme_options', $default_config );
    restore_current_blog();
}
