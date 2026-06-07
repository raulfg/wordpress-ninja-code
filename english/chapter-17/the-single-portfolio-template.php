<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <article class="portfolio-single" id="post-<?php the_ID(); ?>">

        <header class="portfolio-header">
            <h1 class="portfolio-title"><?php the_title(); ?></h1>

            <?php
            $client_name = get_field( 'client_name' );
            $project_url = get_field( 'project_url' );
            ?>

            <?php if ( $client_name ) : ?>
                <p class="portfolio-client">
                    Client: <?php echo esc_html( $client_name ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $project_url ) : ?>
                <a href="<?php echo esc_url( $project_url ); ?>" class="portfolio-link">
                    View project
                </a>
            <?php endif; ?>
        </header>

        <div class="portfolio-content">
            <?php the_content(); ?>
        </div>

        <?php
        $images = get_field( 'project_images' );

        if ( $images ) :
        ?>
            <section class="portfolio-gallery">
                <h2>Project images</h2>
                <ul class="gallery-grid">
                    <?php foreach ( $images as $image ) : ?>
                        <li>
                            <img
                                src="<?php echo esc_url( $image['sizes']['medium_large'] ); ?>"
                                alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                width="<?php echo (int) $image['sizes']['medium_large-width']; ?>"
                                height="<?php echo (int) $image['sizes']['medium_large-height']; ?>"
                            />
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php
        $related = get_field( 'related_posts' );

        if ( $related ) :
        ?>
            <section class="portfolio-related">
                <h2>Related projects</h2>
                <ul>
                    <?php foreach ( $related as $related_post ) : ?>
                        <li>
                            <a href="<?php echo esc_url( get_permalink( $related_post->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $related_post->ID ) ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

    </article>

<?php endwhile; ?>

<?php get_footer(); ?>
