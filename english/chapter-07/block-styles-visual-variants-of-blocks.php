add_action( 'init', function(): void {
    // Add a variant to the Quote block
    register_block_style( 'core/quote', [
        'name'  => 'ninja-highlight',
        'label' => 'Highlight',
    ] );

    // Add a variant to the Image block
    register_block_style( 'core/image', [
        'name'  => 'circular',
        'label' => 'Circular',
    ] );

    // Remove an existing style
    unregister_block_style( 'core/quote', 'large' );
} );
