<?php
/**
 * render.php — ninjatheme/portfolio-grid
 *
 * Available variables:
 *   $attributes — block attributes
 *   $content    — Inner Blocks content (empty in this block)
 *   $block      — WP_Block instance
 */

$columns      = isset( $attributes['columns'] )     ? absint( $attributes['columns'] )           : 3;
$per_page     = isset( $attributes['perPage'] )     ? absint( $attributes['perPage'] )            : 9;
$category     = isset( $attributes['category'] )    ? sanitize_text_field( $attributes['category'] ) : '';
$show_excerpt = isset( $attributes['showExcerpt'] ) ? (bool) $attributes['showExcerpt']           : false;
$orderby      = isset( $attributes['orderby'] )
    ? ( in_array( $attributes['orderby'], [ 'date', 'title', 'menu_order' ], true )
        ? $attributes['orderby']
        : 'date' )
    : 'date';

$query_args = [
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'orderby'        => $orderby,
    'order'          => 'DESC',
    'no_found_rows'  => true,
];

if ( $category ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'portfolio-category',
            'field'    => 'slug',
            'terms'    => $category,
        ],
    ];
}

$portfolio_query = new WP_Query( $query_args );

if ( ! $portfolio_query->have_posts() ) {
    return;
}

// get_block_wrapper_attributes() generates class, style, id and other attributes
// that WordPress adds according to the `supports` declared in block.json.
$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => sprintf( 'portfolio-grid portfolio-grid--cols-%d', $columns ),
    'style' => sprintf( '--portfolio-columns:%d', $columns ),
] );
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
        <?php
        $categories_list = get_the_terms( get_the_ID(), 'portfolio-category' );
        $client          = get_post_meta( get_the_ID(), '_npe_client_name', true );
        ?>
        <article class="portfolio-card" id="portfolio-<?php the_ID(); ?>">

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="portfolio-card__thumb">
                    <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                        <?php
                        the_post_thumbnail( 'medium_large', [
                            'loading'  => 'lazy',
                            'decoding' => 'async',
                            'class'    => 'portfolio-card__image',
                        ] );
                        ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="portfolio-card__body">
                <h3 class="portfolio-card__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ( $client ) : ?>
                    <p class="portfolio-card__client">
                        <?php echo esc_html( $client ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( $show_excerpt && has_excerpt() ) : ?>
                    <div class="portfolio-card__excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $categories_list && ! is_wp_error( $categories_list ) ) : ?>
                    <div class="portfolio-card__categories">
                        <?php foreach ( $categories_list as $cat ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                               class="portfolio-cat">
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
wp_reset_postdata();
