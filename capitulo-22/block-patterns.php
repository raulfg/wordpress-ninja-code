add_action( 'init', 'ninjatheme_register_block_patterns' );

function ninjatheme_register_block_patterns() {
    register_block_pattern(
        'ninjatheme/hero-proyecto',
        [
            'title'       => 'Hero de proyecto',
            'description' => 'Cabecera con imagen, título y descripción breve.',
            'categories'  => [ 'featured' ],
            'content'     => '<!-- wp:group {"className":"hero-proyecto"} -->
<div class="wp-block-group hero-proyecto">
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Título del proyecto</h1>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Descripción breve del proyecto.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
        ]
    );
}
