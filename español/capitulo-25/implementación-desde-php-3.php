add_action( 'wp_head', 'ninjatheme_social_meta', 5 );

function ninjatheme_social_meta(): void {
    // No añadir si Yoast o Rank Math están activos (ellos lo gestionan)
    if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
        return;
    }

    if ( is_singular() ) {
        $post        = get_queried_object();
        $title       = get_the_title( $post );
        $description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( get_the_content( null, false, $post ), 55 );
        $url         = get_permalink( $post );
        $image_url   = get_the_post_thumbnail_url( $post, 'large' ) ?: get_site_icon_url( 1200 );
        $type        = 'post' === $post->post_type ? 'article' : 'website';
    } else {
        $title       = get_bloginfo( 'name' );
        $description = get_bloginfo( 'description' );
        $url         = home_url( '/' );
        $image_url   = get_site_icon_url( 1200 ) ?: '';
        $type        = 'website';
    }

    ?>
    <meta property="og:type"        content="<?php echo esc_attr( $type ); ?>">
    <meta property="og:title"       content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
    <meta property="og:url"         content="<?php echo esc_url( $url ); ?>">
    <?php if ( $image_url ) : ?>
    <meta property="og:image"       content="<?php echo esc_url( $image_url ); ?>">
    <?php endif; ?>
    <meta property="og:site_name"   content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
    <meta name="twitter:card"       content="summary_large_image">
    <meta name="twitter:title"      content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
    <?php if ( $image_url ) : ?>
    <meta name="twitter:image"      content="<?php echo esc_url( $image_url ); ?>">
    <?php endif; ?>
    <?php
}
