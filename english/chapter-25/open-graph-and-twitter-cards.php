add_action( 'wp_head', function(): void {
    if ( ! is_singular() ) {
        return;
    }

    $title       = get_the_title();
    $description = has_excerpt()
        ? wp_strip_all_tags( get_the_excerpt() )
        : wp_trim_words( get_the_content(), 25 );
    $image       = get_the_post_thumbnail_url( null, 'large' ) ?: get_site_icon_url();
    $url         = get_permalink();

    ?>
    <meta property="og:type"        content="article">
    <meta property="og:title"       content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
    <meta property="og:image"       content="<?php echo esc_url( $image ); ?>">
    <meta property="og:url"         content="<?php echo esc_url( $url ); ?>">
    <meta name="twitter:card"       content="summary_large_image">
    <?php
} );
