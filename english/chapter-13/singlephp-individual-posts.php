<?php
/**
 * single.php — Template for individual posts
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'single' );

        // Navigation between previous/next posts
        the_post_navigation( [
            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'ninjatheme' ) . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'ninjatheme' ) . '</span> <span class="nav-title">%title</span>',
        ] );

        // Comments section if open
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

    endwhile;
    ?>
</main>

<?php get_footer(); ?>
