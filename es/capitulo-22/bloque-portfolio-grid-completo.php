<?php
$columns  = isset( $attributes['columns'] ) ? (int) $attributes['columns'] : 3;
$category = isset( $attributes['category'] ) ? sanitize_text_field( $attributes['category'] ) : '';

$query_args = [
    'post_type'      => 'portfolio',
    'posts_per_page' => 12,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

if ( $category ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'portfolio_category',
            'field'    => 'slug',
            'terms'    => $category,
        ],
    ];
}

$portfolio_query = new WP_Query( $query_args );

if ( ! $portfolio_query->have_posts() ) {
    return;
}

$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'portfolio-grid',
    'style' => '--columns:' . $columns,
] );
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
        <article class="portfolio-grid__item">
            <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="portfolio-grid__image">
                    <?php the_post_thumbnail( 'medium_large' ); ?>
                </a>
            <?php endif; ?>
            <h3 class="portfolio-grid__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </article>
    <?php endwhile; ?>
</div>
<?php
wp_reset_postdata();
