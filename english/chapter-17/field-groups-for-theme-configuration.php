add_action( 'acf/init', function(): void {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title' => 'NinjaTheme Options',
        'menu_title' => 'Theme options',
        'menu_slug'  => 'ninjatheme-options',
        'capability' => 'manage_options',
        'position'   => 80,
        'autoload'   => true, // Pre-load into memory for better performance
    ] );

    acf_add_local_field_group( [
        'key'    => 'group_theme_options',
        'title'  => 'Global options',
        'fields' => [
            [
                'key'   => 'field_header_phone',
                'label' => 'Contact phone',
                'name'  => 'header_phone',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_logo_dark',
                'label'         => 'Dark version logo',
                'name'          => 'logo_dark',
                'type'          => 'image',
                'return_format' => 'array',
            ],
            [
                'key'   => 'field_google_analytics',
                'label' => 'Google Analytics 4 ID',
                'name'  => 'ga4_id',
                'type'  => 'text',
                'placeholder' => 'G-XXXXXXXXXX',
            ],
        ],
        'location' => [
            [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'ninjatheme-options' ] ],
        ],
    ] );
} );
