add_action( 'init', function(): void {
    // Añadir una variante al bloque Quote
    register_block_style( 'core/quote', [
        'name'  => 'ninja-highlight',
        'label' => 'Destacado',
    ] );

    // Añadir una variante al bloque Image
    register_block_style( 'core/image', [
        'name'  => 'circular',
        'label' => 'Circular',
    ] );

    // Eliminar un estilo existente
    unregister_block_style( 'core/quote', 'large' );
} );
