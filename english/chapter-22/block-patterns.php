add_action( 'init', 'ninjatheme_register_block_patterns' );

function ninjatheme_register_block_patterns() {
    register_block_pattern(
        'ninjatheme/hero-proyecto',
        [
            'title'       => 'Project hero',
            'description' => 'Header with image, title and short description.',
            'categories'  => [ 'featured' ],
            'content'     => '<!-- wp:group {"className":"hero-proyecto"} -->
<div class="wp-block-group hero-proyecto">
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Project title</h1>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Brief project description.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
        ]
    );
}
