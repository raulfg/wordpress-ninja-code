<?php
/**
 * single-portfolio.php
 * Plantilla para proyectos individuales del portfolio.
 */

get_header();
?>

<main id="main" class="site-main single-portfolio">
    <?php
    while ( have_posts() ) :
        the_post();
    ?>

        <article id="portfolio-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="portfolio-hero">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                <?php endif; ?>

                <h1 class="entry-title"><?php the_title(); ?></h1>

                <?php
                // Categorías del portfolio
                $cats = get_the_terms( get_the_ID(), 'portfolio-category' );
                if ( $cats && ! is_wp_error( $cats ) ) :
                ?>
                    <div class="portfolio-categories">
                        <?php foreach ( $cats as $cat ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                               class="portfolio-cat-link">
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php
                // Metadatos del proyecto (registrados con register_meta o ACF)
                $proyecto_url  = get_post_meta( get_the_ID(), '_npe_project_url', true );
                $cliente       = get_post_meta( get_the_ID(), '_npe_client_name', true );
                $anio_proyecto  = get_post_meta( get_the_ID(), '_npe_project_year', true );
                ?>

                <?php if ( $proyecto_url || $cliente || $anio_proyecto ) : ?>
                    <dl class="portfolio-meta">
                        <?php if ( $cliente ) : ?>
                            <dt><?php esc_html_e( 'Cliente', 'ninjatheme' ); ?></dt>
                            <dd><?php echo esc_html( $cliente ); ?></dd>
                        <?php endif; ?>

                        <?php if ( $anio_proyecto ) : ?>
                            <dt><?php esc_html_e( 'Año', 'ninjatheme' ); ?></dt>
                            <dd><?php echo esc_html( $anio_proyecto ); ?></dd>
                        <?php endif; ?>

                        <?php if ( $proyecto_url ) : ?>
                            <dt><?php esc_html_e( 'Enlace', 'ninjatheme' ); ?></dt>
                            <dd>
                                <a href="<?php echo esc_url( $proyecto_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <?php esc_html_e( 'Ver proyecto', 'ninjatheme' ); ?>
                                </a>
                            </dd>
                        <?php endif; ?>
                    </dl>
                <?php endif; ?>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

        </article>

        <?php
        // Proyectos anteriores y siguientes dentro del mismo CPT
        the_post_navigation( [
            'in_same_term'          => true,
            'taxonomy'              => 'portfolio-category',
            'prev_text'             => '%title',
            'next_text'             => '%title',
            'screen_reader_text'    => __( 'Navegación de proyectos', 'ninjatheme' ),
        ] );
        ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
