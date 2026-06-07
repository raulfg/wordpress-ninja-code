<?php
/**
 * Template Name: Page without sidebar
 * Template Post Type: page, portfolio
 *
 * @package NinjaTheme
 */

get_header();
?>

<main class="site-main site-main--full-width" role="main">
    <?php
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/content/content', 'page' );
    }
    ?>
</main>

<?php
get_footer();
