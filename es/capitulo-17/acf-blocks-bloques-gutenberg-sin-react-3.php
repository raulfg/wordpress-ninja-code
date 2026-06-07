// Usando la API PHP de ACF (sin UI)
acf_add_local_field_group( [
    'key'      => 'group_portfolio_card_block',
    'title'    => 'Portfolio Card Block',
    'fields'   => [
        [
            'key'           => 'field_portfolio_card_proyecto',
            'label'         => 'Proyecto',
            'name'          => 'proyecto',
            'type'          => 'post_object',
            'post_type'     => [ 'portfolio' ],
            'return_format' => 'object',
        ],
        [
            'key'           => 'field_portfolio_card_cliente',
            'label'         => 'Mostrar cliente',
            'name'          => 'mostrar_cliente',
            'type'          => 'true_false',
            'default_value' => 1,
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'acf/portfolio-card',
            ],
        ],
    ],
] );
