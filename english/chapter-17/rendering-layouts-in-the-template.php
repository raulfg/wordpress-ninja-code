// template-parts/sections/features.php
$section_title = $args['section_title'] ?? '';
$items         = $args['items'] ?? [];
?>
<section class="features-section">
    <?php if ( $section_title ) : ?>
    <h2><?php echo esc_html( $section_title ); ?></h2>
    <?php endif; ?>
    <div class="features-grid">
        <?php foreach ( $items as $item ) : ?>
        <div class="feature-card">
            <?php if ( $item['icon'] ) : ?>
            <span class="dashicons dashicons-<?php echo esc_attr( $item['icon'] ); ?>"></span>
            <?php endif; ?>
            <p><?php echo esc_html( $item['text'] ); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
