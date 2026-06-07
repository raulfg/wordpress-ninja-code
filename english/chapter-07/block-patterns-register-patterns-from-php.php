add_action( 'init', function(): void {
    register_block_pattern_category( 'ninjatheme', [
        'label' => 'NinjaTheme',
    ] );

    register_block_pattern(
        'ninjatheme/hero-portfolio',
        [
            'title'       => 'Hero with portfolio listing',
            'description' => 'Hero section with title and grid of latest projects.',
            'categories'  => [ 'ninjatheme' ],
            'keywords'    => [ 'hero', 'portfolio', 'projects' ],
            'content'     => '<!-- wp:group {"tagName":"section","className":"ninja-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group ninja-hero">
    <!-- wp:heading {"level":1,"textAlign":"center"} -->
    <h1 class="wp-block-heading has-text-align-center">Projects</h1>
    <!-- /wp:heading -->
    <!-- wp:query {"queryId":0,"query":{"perPage":6,"postType":"portfolio","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"grid","columnCount":3}} -->
    <div class="wp-block-query">
        <!-- wp:post-template -->
        <!-- wp:post-featured-image {"isLink":true} /-->
        <!-- wp:post-title {"isLink":true,"level":3} /-->
        <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
</section>
<!-- /wp:group -->',
        ]
    );
} );
