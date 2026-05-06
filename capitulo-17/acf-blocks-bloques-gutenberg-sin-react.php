add_action( 'acf/init', 'ninjatheme_register_acf_blocks' );

function ninjatheme_register_acf_blocks(): void {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    acf_register_block_type( [
        'name'            => 'portfolio-card',
        'title'           => 'Portfolio Card',
        'description'     => 'Muestra un proyecto del portfolio con metadatos.',
        'category'        => 'ninjatheme',
        'icon'            => 'portfolio',
        'keywords'        => [ 'portfolio', 'proyecto', 'card' ],
        'render_template' => get_template_directory() . '/template-parts/blocks/portfolio-card.php',
        'enqueue_style'   => get_template_directory_uri() . '/assets/css/blocks/portfolio-card.css',
        'supports'        => [
            'align'  => [ 'wide', 'full' ],
            'anchor' => true,
        ],
    ] );
}
