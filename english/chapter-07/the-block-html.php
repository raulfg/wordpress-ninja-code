<?php
// render.php for the ninjatheme/portfolio-filter block

$namespace = 'ninjatheme/portfolio-filter';
?>
<div
    <?php echo get_block_wrapper_attributes(); ?>
    data-wp-interactive="<?php echo esc_attr( $namespace ); ?>"
    <?php echo wp_interactivity_state( $namespace, [
        'filter'         => 'all',
        'isLoading'      => false,
        'totalProjects'  => count( $projects ),
    ] ); ?>
>
    <!-- Filter buttons -->
    <nav class="filter-nav">
        <button
            data-wp-on--click="actions.setFilter"
            data-wp-bind--aria-pressed="state.isFilterActive"
            data-filter="all"
        >
            <?php esc_html_e( 'All', 'ninjatheme' ); ?>
        </button>
        <?php foreach ( $categories as $category ) : ?>
        <button
            data-wp-on--click="actions.setFilter"
            data-wp-bind--data-filter="context.slug"
            data-wp-context='<?php echo esc_attr( wp_json_encode( [ 'slug' => $category->slug ] ) ); ?>'
        >
            <?php echo esc_html( $category->name ); ?>
        </button>
        <?php endforeach; ?>
    </nav>

    <!-- Reactive counter -->
    <p data-wp-text="state.filterLabel"></p>

    <!-- Project list with dynamic visibility -->
    <div class="projects-grid">
        <?php foreach ( $projects as $project ) : ?>
        <article
            data-wp-context='<?php echo esc_attr( wp_json_encode( [
                'categories' => wp_get_post_terms( $project->ID, 'portfolio-category', [ 'fields' => 'slugs' ] ),
            ] ) ); ?>'
            data-wp-class--hidden="state.isProjectHidden"
        >
            <h3><?php echo esc_html( get_the_title( $project ) ); ?></h3>
        </article>
        <?php endforeach; ?>
    </div>
</div>
