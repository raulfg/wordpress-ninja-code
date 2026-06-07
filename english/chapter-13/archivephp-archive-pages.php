<?php
/**
 * archive.php — Categories, tags, dates, authors
 */

get_header();
?>

<main id="main" class="site-main">

    <header class="page-header">
        <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
        <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
    </header>

    <?php if ( have_posts() ) : ?>

        <div class="posts-loop">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', get_post_type() );
            endwhile;
            ?>
        </div>

        <?php the_posts_pagination( [
            'prev_text' => esc_html__( 'Previous', 'ninjatheme' ),
            'next_text' => esc_html__( 'Next', 'ninjatheme' ),
        ] ); ?>

    <?php else : ?>

        <?php get_template_part( 'template-parts/content', 'none' ); ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
