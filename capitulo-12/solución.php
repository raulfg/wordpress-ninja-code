<?php
/**
 * archive-portfolio.php
 * Template para el archivo del CPT portfolio.
 * Funciona tanto en /portfolio/ como en /portfolio-category/{slug}/
 */

get_header();

// Obtener la página actual para la paginación
$paged = max( 1, get_query_var( 'paged' ) );

// Argumentos base de la query
$args = [
    'post_type'      => 'portfolio',
    'posts_per_page' => 9,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'paged'          => $paged,
];

// Si estamos en el archivo de una taxonomía, añadir el filtro
if ( is_tax( 'portfolio_category' ) ) {
    $current_term = get_queried_object();
    $args['tax_query'] = [
        [
            'taxonomy' => 'portfolio_category',
            'field'    => 'term_id',
            'terms'    => $current_term->term_id,
        ],
    ];
}

$portfolio_query = new WP_Query( $args );
?>

<main class="archive-portfolio">

    <?php if ( is_tax( 'portfolio_category' ) ) : ?>
        <header class="archive-header">
            <h1><?php single_term_title(); ?></h1>
            <?php
            $term_description = term_description();
            if ( $term_description ) {
                echo '<div class="term-description">' . wp_kses_post( $term_description ) . '</div>';
            }
            ?>
        </header>
    <?php else : ?>
        <header class="archive-header">
            <h1><?php esc_html_e( 'Portfolio', 'ninjatheme' ); ?></h1>
        </header>
    <?php endif; ?>

    <?php if ( $portfolio_query->have_posts() ) : ?>

        <div class="portfolio-grid">
            <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>

                <article id="portfolio-<?php the_ID(); ?>" class="portfolio-item">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="portfolio-thumb">
                            <?php the_post_thumbnail( 'portfolio-card' ); ?>
                        </a>
                    <?php endif; ?>

                    <div class="portfolio-item-body">
                        <h2 class="portfolio-item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <?php
                        // Mostrar las categorías del proyecto
                        $categories = get_the_terms( get_the_ID(), 'portfolio_category' );
                        if ( $categories && ! is_wp_error( $categories ) ) :
                        ?>
                            <div class="portfolio-item-cats">
                                <?php foreach ( $categories as $cat ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
                                        <?php echo esc_html( $cat->name ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

            <?php endwhile; ?>
        </div>

        <?php
        // Paginación
        $pagination = paginate_links( [
            'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $portfolio_query->max_num_pages,
            'prev_text' => '&laquo; ' . __( 'Anterior', 'ninjatheme' ),
            'next_text' => __( 'Siguiente', 'ninjatheme' ) . ' &raquo;',
        ] );

        if ( $pagination ) {
            echo '<nav class="portfolio-pagination" aria-label="' . esc_attr__( 'Paginación del portfolio', 'ninjatheme' ) . '">';
            echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo '</nav>';
        }

        wp_reset_postdata();
        ?>

    <?php else : ?>

        <p><?php esc_html_e( 'No hay proyectos en el portfolio.', 'ninjatheme' ); ?></p>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
