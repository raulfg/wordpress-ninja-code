// En el render_callback del bloque
$context = wp_interactivity_state( 'ninjatheme/portfolio-filter', [
    'activeCategory' => '',
    'isLoading'      => false,
] );

?>
<div
    data-wp-interactive="ninjatheme/portfolio-filter"
    data-wp-context='{"activeCategory": "", "isLoading": false}'
>
    <!-- Botones de filtro -->
    <div class="ninja-filter-buttons" data-wp-interactive="ninjatheme/portfolio-filter">
        <?php foreach ( $categories as $cat ) : ?>
        <button
            data-wp-on--click="actions.setFilter"
            data-wp-bind--data-active="state.activeCategory === context.slug"
            data-wp-context='{"slug": "<?php echo esc_js( $cat->slug ); ?>"}'
        >
            <?php echo esc_html( $cat->name ); ?>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Listado de proyectos -->
    <div class="ninja-portfolio-grid" data-wp-class--is-loading="state.isLoading">
        <?php foreach ( $posts as $post ) : ?>
        <?php $cat_slugs = wp_json_encode(
            array_map( fn( $t ) => $t->slug, get_the_terms( $post, 'portfolio-category' ) ?: [] )
        ); ?>
        <article
            class="ninja-portfolio-item"
            data-wp-bind--hidden="state.activeCategory !== '' && !context.categories.includes(state.activeCategory)"
            data-wp-context='{"categories": <?php echo $cat_slugs; ?>}'
        >
            <h3><?php echo esc_html( $post->post_title ); ?></h3>
        </article>
        <?php endforeach; ?>
    </div>
</div>
