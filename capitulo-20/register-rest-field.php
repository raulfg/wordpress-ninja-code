add_action( 'rest_api_init', 'ninjatheme_register_rest_fields' );

function ninjatheme_register_rest_fields(): void {
    register_rest_field(
        'portfolio',
        'project_url',
        [
            'get_callback'    => 'ninjatheme_get_project_url',
            'update_callback' => 'ninjatheme_update_project_url',
            'schema'          => [
                'description' => 'URL del proyecto en producción.',
                'type'        => 'string',
                'format'      => 'uri',
                'context'     => [ 'view', 'edit' ],
            ],
        ]
    );

    register_rest_field(
        'portfolio',
        'client_name',
        [
            'get_callback'    => 'ninjatheme_get_client_name',
            'update_callback' => null,
            'schema'          => [
                'description' => 'Nombre del cliente.',
                'type'        => 'string',
                'context'     => [ 'view', 'edit' ],
            ],
        ]
    );
}
