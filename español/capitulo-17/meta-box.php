add_filter( 'rwmb_meta_boxes', 'ninjatheme_register_meta_boxes' );

function ninjatheme_register_meta_boxes( array $meta_boxes ): array {
    $meta_boxes[] = [
        'title'      => 'Detalles del proyecto',
        'post_types' => [ 'portfolio' ],
        'fields'     => [
            [
                'id'   => 'client_name',
                'name' => 'Cliente',
                'type' => 'text',
            ],
            [
                'id'   => 'project_url',
                'name' => 'URL del proyecto',
                'type' => 'url',
            ],
        ],
    ];

    return $meta_boxes;
}
