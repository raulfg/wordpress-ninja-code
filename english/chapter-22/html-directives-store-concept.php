<?php
/**
 * @var array    $attributes
 * @var string   $content
 * @var WP_Block $block
 */
$pregunta  = esc_html( $attributes['pregunta'] ?? '' );
$respuesta = wp_kses_post( $attributes['respuesta'] ?? '' );
?>
<div
    <?php echo get_block_wrapper_attributes(); ?>
    data-wp-interactive="mi-tema/acordeon"
    data-wp-context='{"abierto": false}'
>
    <button
        type="button"
        data-wp-on--click="actions.toggle"
        data-wp-bind--aria-expanded="context.abierto"
    >
        <?php echo $pregunta; ?>
    </button>

    <div
        data-wp-bind--hidden="!context.abierto"
        data-wp-class--is-visible="context.abierto"
    >
        <?php echo $respuesta; ?>
    </div>
</div>
