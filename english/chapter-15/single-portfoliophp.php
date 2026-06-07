<?php
/**
 * single-portfolio.php
 * Template for individual portfolio projects.
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
                // Portfolio categories
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
                // Project metadata (registered with register_meta or ACF)
                $project_url  = get_post_meta( get_the_ID(), '_npe_project_url', true );
                $client       = get_post_meta( get_the_ID(), '_npe_client_name', true );
                $project_year = get_post_meta( get_the_ID(), '_npe_project_year', true );
                ?>

                <?php if ( $project_url || $client || $project_year ) : ?>
                    <dl class="portfolio-meta">
                        <?php if ( $client ) : ?>
                            <dt><?php esc_html_e( 'Client', 'ninjatheme' ); ?></dt>
                            <dd><?php echo esc_html( $client ); ?></dd>
                        <?php endif; ?>

                        <?php if ( $project_year ) : ?>
                            <dt><?php esc_html_e( 'Year', 'ninjatheme' ); ?></dt>
                            <dd><?php echo esc_html( $project_year ); ?></dd>
                        <?php endif; ?>

                        <?php if ( $project_url ) : ?>
                            <dt><?php esc_html_e( 'Link', 'ninjatheme' ); ?></dt>
                            <dd>
                                <a href="<?php echo esc_url( $project_url ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <?php esc_html_e( 'View project', 'ninjatheme' ); ?>
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
        // Previous and next projects within the same CPT
        the_post_navigation( [
            'in_same_term'          => true,
            'taxonomy'              => 'portfolio-category',
            'prev_text'             => '%title',
            'next_text'             => '%title',
            'screen_reader_text'    => __( 'Project navigation', 'ninjatheme' ),
        ] );
        ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
