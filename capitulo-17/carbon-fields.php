function ninjatheme_register_carbon_fields(): void {
    Container::make( 'post_meta', 'Detalles del proyecto' )
        ->where( 'post_type', '=', 'portfolio' )
        ->add_fields(
            [
                Field::make( 'text', 'client_name', 'Cliente' ),
                Field::make( 'text', 'project_url', 'URL del proyecto' )
                    ->set_attribute( 'type', 'url' ),
                Field::make( 'media_gallery', 'project_images', 'Imágenes del proyecto' )
                    ->set_type( [ 'image' ] ),
                Field::make( 'association', 'related_posts', 'Proyectos relacionados' )
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
