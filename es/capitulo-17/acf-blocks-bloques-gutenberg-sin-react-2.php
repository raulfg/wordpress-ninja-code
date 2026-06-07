<?php
/**
 * template-parts/blocks/portfolio-card.php
 *
 * @var array  $block  Los atributos del bloque.
 * @var bool   $is_preview  Si estamos en el editor de bloques.
 */

$project     = get_field( 'proyecto' );        // campo post_object → WP_Post
$show_client = get_field( 'mostrar_cliente' ); // campo true_false

if ( ! $project ) {
    if ( $is_preview ) {
        echo '<p>Selecciona un proyecto en el panel lateral.</p>';
    }
    return;
}

$thumbnail = get_the_post_thumbnail_url( $project, 'portfolio-card' );
$client    = get_field( 'client_name', $project->ID );
?>

<div class="acf-block-portfolio-card <?php echo esc_attr( $block['className'] ?? '' ); ?>">
    <?php if ( $thumbnail ) : ?>
        <img src="<?php echo esc_url( $thumbnail ); ?>"
             alt="<?php echo esc_attr( get_the_title( $project ) ); ?>">
    <?php endif; ?>

    <h3><?php echo esc_html( get_the_title( $project ) ); ?></h3>

    <?php if ( $show_client && $client ) : ?>
        <p class="client"><?php echo esc_html( $client ); ?></p>
    <?php endif; ?>

    <a href="<?php echo esc_url( get_permalink( $project ) ); ?>">
        <?php esc_html_e( 'Ver proyecto', 'ninjatheme' ); ?>
    </a>
</div>
