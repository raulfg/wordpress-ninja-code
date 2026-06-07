<?php
/**
 * template-parts/content-post.php
 * Muestra una entrada en listados (archive, home, search).
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="entry-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail( 'medium_large' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <header class="entry-header">
            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

            <div class="entry-meta">
                <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
                <span class="entry-author">
                    <?php esc_html_e( 'por', 'ninjatheme' ); ?>
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                        <?php the_author(); ?>
                    </a>
                </span>
            </div>
        </header>

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>

        <footer class="entry-footer">
            <?php
            $categories = get_the_category();
            if ( $categories ) :
                echo '<div class="entry-categories">';
                foreach ( $categories as $cat ) :
                    echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
                endforeach;
                echo '</div>';
            endif;
            ?>
        </footer>
    </div>

</article>
