// En template-parts/components/portfolio-card.php
$post_id     = $args['post_id'] ?? get_the_ID();
$show_client = $args['show_client'] ?? false;
$image_size  = $args['image_size'] ?? 'medium';

$client = $show_client
    ? get_post_meta( $post_id, '_npe_client_name', true )
    : '';
?>
<article class="portfolio-card">
    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
    <figure class="portfolio-card__image">
        <?php echo get_the_post_thumbnail( $post_id, $image_size ); ?>
    </figure>
    <?php endif; ?>
    <div class="portfolio-card__body">
        <h3><?php echo esc_html( get_the_title( $post_id ) ); ?></h3>
        <?php if ( $client ) : ?>
        <p class="portfolio-card__client"><?php echo esc_html( $client ); ?></p>
        <?php endif; ?>
    </div>
</article>
