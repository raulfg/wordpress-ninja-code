add_action( 'acf/init', function(): void {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title' => 'Opciones de NinjaTheme',
        'menu_title' => 'Opciones del tema',
        'menu_slug'  => 'ninjatheme-options',
        'capability' => 'manage_options',
        'position'   => 80,
        'autoload'   => true, // Pre-cargar en memoria para mejor rendimiento
    ] );

    acf_add_local_field_group( [
        'key'    => 'group_theme_options',
        'title'  => 'Opciones globales',
        'fields' => [
            [
                'key'   => 'field_header_phone',
                'label' => 'Teléfono de contacto',
                'name'  => 'header_phone',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_logo_dark',
                'label'         => 'Logo versión oscura',
                'name'          => 'logo_dark',
                'type'          => 'image',
                'return_format' => 'array',
            ],
            [
                'key'   => 'field_google_analytics',
                'label' => 'ID de Google Analytics 4',
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
