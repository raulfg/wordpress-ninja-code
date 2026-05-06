<!-- templates/archive-portfolio.html (block theme) -->
<!-- O en archive-portfolio.php (tema clásico) -->

<div class="portfolio-filter-bar" role="navigation" aria-label="Filtrar portfolio">
    <button class="filter-btn is-active"
            data-portfolio-filter=""
            aria-pressed="true">
        <?php esc_html_e( 'Todos', 'ninjatheme' ); ?>
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
    // SSR: renderizar los primeros proyectos directamente en PHP
    // El script JS detecta que hay proyectos y no los vuelve a cargar
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/portfolio', 'card' );
    endwhile;
    ?>
</div>

<button id="portfolio-load-more" class="btn btn--outline" hidden>
    <?php esc_html_e( 'Cargar más', 'ninjatheme' ); ?>
</button>
