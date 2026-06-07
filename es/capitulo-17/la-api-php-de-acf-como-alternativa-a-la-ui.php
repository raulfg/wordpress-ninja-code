add_action( 'acf/init', function (): void {
    acf_add_local_field_group( [
        'key'      => 'group_portfolio_meta',
        'title'    => 'Datos del proyecto',
        'fields'   => [
            [
                'key'               => 'field_proyecto_url',
                'label'             => 'URL del proyecto',
                'name'              => 'proyecto_url',
                'type'              => 'url',
                'instructions'      => 'URL completa del proyecto en producción.',
                'required'          => 0,
                'conditional_logic' => 0,
            ],
            [
                'key'               => 'field_proyecto_cliente',
                'label'             => 'Cliente',
                'name'              => 'proyecto_cliente',
                'type'              => 'text',
                'required'          => 0,
            ],
            [
                'key'               => 'field_proyecto_year',
                'label'             => 'Año',
                'name'              => 'proyecto_year',
                'type'              => 'number',
                'min'               => 2000,
                'max'               => date( 'Y' ),
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'portfolio',
                ],
            ],
        ],
        'position'      => 'normal',
        'style'         => 'default',
        'label_placement' => 'top',
    ] );
} );
