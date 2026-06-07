add_action( 'acf/init', function(): void {
    acf_add_local_field_group( [
        'key'    => 'group_page_builder',
        'title'  => 'Page builder',
        'fields' => [
            [
                'key'          => 'field_flexible_content',
                'label'        => 'Sections',
                'name'         => 'page_sections',
                'type'         => 'flexible_content',
                'button_label' => 'Add section',
                'layouts'      => [

                    // Layout 1: Hero section
                    [
                        'key'    => 'layout_hero',
                        'name'   => 'hero',
                        'label'  => 'Hero Section',
                        'sub_fields' => [
                            [
                                'key'   => 'field_hero_title',
                                'label' => 'Title',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'      => 'field_hero_image',
                                'label'    => 'Background image',
                                'name'     => 'background',
                                'type'     => 'image',
                                'return_format' => 'array',
                            ],
                        ],
                    ],

                    // Layout 2: Features grid
                    [
                        'key'    => 'layout_features',
                        'name'   => 'features',
                        'label'  => 'Features Grid',
                        'sub_fields' => [
                            [
                                'key'   => 'field_features_title',
                                'label' => 'Section title',
                                'name'  => 'section_title',
                                'type'  => 'text',
                            ],
                            [
                                'key'        => 'field_features_items',
                                'label'      => 'Features',
                                'name'       => 'items',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 6,
                                'sub_fields' => [
                                    [
                                        'key'   => 'field_feature_icon',
                                        'label' => 'Icon (dashicon)',
                                        'name'  => 'icon',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_feature_text',
                                        'label' => 'Description',
                                        'name'  => 'text',
                                        'type'  => 'textarea',
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // Layout 3: Text and media block
                    [
                        'key'    => 'layout_text_media',
                        'name'   => 'text_media',
                        'label'  => 'Text and Media',
                        'sub_fields' => [
                            [
                                'key'     => 'field_tm_layout',
                                'label'   => 'Layout',
                                'name'    => 'layout',
                                'type'    => 'select',
                                'choices' => [
                                    'text-left'  => 'Text on the left',
                                    'text-right' => 'Text on the right',
                                ],
                                'default_value' => 'text-left',
                            ],
                            [
                                'key'   => 'field_tm_content',
                                'label' => 'Content',
                                'name'  => 'content',
                                'type'  => 'wysiwyg',
                            ],
                            [
                                'key'           => 'field_tm_image',
                                'label'         => 'Image',
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
