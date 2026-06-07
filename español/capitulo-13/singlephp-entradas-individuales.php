<?php
/**
 * single.php — Plantilla para entradas individuales
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'single' );

        // Navegación entre entradas anterior/siguiente
        the_post_navigation( [
            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Anterior', 'ninjatheme' ) . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Siguiente', 'ninjatheme' ) . '</span> <span class="nav-title">%title</span>',
        ] );

        // Sección de comentarios si están abiertos
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
