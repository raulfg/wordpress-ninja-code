<!-- templates/archive-portfolio.html (block theme) -->
<!-- Or in archive-portfolio.php (classic theme) -->

<div class="portfolio-filter-bar" role="navigation" aria-label="Filter portfolio">
    <button class="filter-btn is-active"
            data-portfolio-filter=""
            aria-pressed="true">
        <?php esc_html_e( 'All', 'ninjatheme' ); ?>
    </button>

    <?php
    $categories = get_terms( [
        'taxonomy'   => 'portfolio-category',
        'hide_empty' => true,
    ] );
    foreach ( $categories as $cat ) : ?>
        <button class="filter-btn"
                data-portfolio-filter="<?php echo esc_attr( $cat->slug ); ?>"
                aria-pressed="false">
            <?php echo esc_html( $cat->name ); ?>
        </button>
    <?php endforeach; ?>
</div>

<div id="portfolio-grid" class="portfolio-grid">
    <?php
    // SSR: render the first projects directly in PHP.
    // The JS script detects existing projects and does not reload them.
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/portfolio', 'card' );
    endwhile;
    ?>
</div>

<button id="portfolio-load-more" class="btn btn--outline" hidden>
    <?php esc_html_e( 'Load more', 'ninjatheme' ); ?>
</button>
