function ninjatheme_register_carbon_fields(): void {
    Container::make( 'post_meta', 'Project details' )
        ->where( 'post_type', '=', 'portfolio' )
        ->add_fields(
            [
                Field::make( 'text', 'client_name', 'Client' ),
                Field::make( 'text', 'project_url', 'Project URL' )
                    ->set_attribute( 'type', 'url' ),
                Field::make( 'media_gallery', 'project_images', 'Project images' )
                    ->set_type( [ 'image' ] ),
                Field::make( 'association', 'related_posts', 'Related projects' )
                    ->set_types(
                        [
                            [
                                'type'      => 'post',
                                'post_type' => 'portfolio',
                            ],
                        ]
                    ),
            ]
        );
}
