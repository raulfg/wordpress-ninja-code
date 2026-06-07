add_filter( 'rwmb_meta_boxes', 'ninjatheme_register_meta_boxes' );

function ninjatheme_register_meta_boxes( array $meta_boxes ): array {
    $meta_boxes[] = [
        'title'      => 'Project details',
        'post_types' => [ 'portfolio' ],
        'fields'     => [
            [
                'id'   => 'client_name',
                'name' => 'Client',
                'type' => 'text',
            ],
            [
                'id'   => 'project_url',
                'name' => 'Project URL',
                'type' => 'url',
            ],
        ],
    ];

    return $meta_boxes;
}
