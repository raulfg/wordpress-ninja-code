add_action( 'acf/init', function(): void {
    acf_add_local_field_group( [
        'key'    => 'group_page_builder',
        'title'  => 'Constructor de página',
        'fields' => [
            [
                'key'          => 'field_flexible_content',
                'label'        => 'Secciones',
                'name'         => 'page_sections',
                'type'         => 'flexible_content',
                'button_label' => 'Añadir sección',
                'layouts'      => [

                    // Layout 1: Sección hero
                    [
                        'key'    => 'layout_hero',
                        'name'   => 'hero',
                        'label'  => 'Sección Hero',
                        'sub_fields' => [
                            [
                                'key'   => 'field_hero_title',
                                'label' => 'Título',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'      => 'field_hero_image',
                                'label'    => 'Imagen de fondo',
                                'name'     => 'background',
                                'type'     => 'image',
                                'return_format' => 'array',
                            ],
                        ],
                    ],

                    // Layout 2: Grid de características
                    [
                        'key'    => 'layout_features',
                        'name'   => 'features',
                        'label'  => 'Grid de características',
                        'sub_fields' => [
                            [
                                'key'   => 'field_features_title',
                                'label' => 'Título de sección',
                                'name'  => 'section_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'        => 'field_features_items',
                                'label'      => 'Características',
                                'name'       => 'items',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 6,
                                'sub_fields' => [
                                    [
                                        'key'   => 'field_feature_icon',
                                        'label' => 'Icono (dashicon)',
                                        'name'  => 'icon',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_feature_text',
                                        'label' => 'Descripción',
                                        'name'  => 'text',
                                        'type'  => 'textarea',
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // Layout 3: Bloque de texto y media
                    [
                        'key'    => 'layout_text_media',
                        'name'   => 'text_media',
                        'label'  => 'Texto y Media',
                        'sub_fields' => [
                            [
                                'key'     => 'field_tm_layout',
                                'label'   => 'Disposición',
                                'name'    => 'layout',
                                'type'    => 'select',
                                'choices' => [
                                    'text-left'  => 'Texto a la izquierda',
                                    'text-right' => 'Texto a la derecha',
                                ],
                                'default_value' => 'text-left',
                            ],
                            [
                                'key'   => 'field_tm_content',
                                'label' => 'Contenido',
                                'name'  => 'content',
                                'type'  => 'wysiwyg',
                            ],
                            [
                                'key'           => 'field_tm_image',
                                'label'         => 'Imagen',
                                'name'          => 'image',
                                'type'          => 'image',
                                'return_format' => 'array',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ],
        ],
    ] );
} );
