add_action( 'acf/init', 'ninjatheme_register_portfolio_fields' );

function ninjatheme_register_portfolio_fields(): void {
    acf_add_local_field_group(
        [
            'key'      => 'group_portfolio_details',
            'title'    => 'Project details',
            'fields'   => [
                [
                    'key'          => 'field_project_url',
                    'label'        => 'Project URL',
                    'name'         => 'project_url',
                    'type'         => 'url',
                    'instructions' => 'Public URL of the completed project.',
                    'required'     => 0,
                ],
                [
                    'key'   => 'field_client_name',
                    'label' => 'Client',
                    'name'  => 'client_name',
                    'type'  => 'text',
                ],
                [
                    'key'          => 'field_project_images',
                    'label'        => 'Project images',
                    'name'         => 'project_images',
                    'type'         => 'gallery',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                ],
                [
                    'key'           => 'field_related_posts',
                    'label'         => 'Related projects',
                    'name'          => 'related_posts',
                    'type'          => 'relationship',
                    'post_type'     => [ 'portfolio' ],
                    'return_format' => 'object',
                    'max'           => 3,
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
        ]
    );
}
