$images = get_field( 'project_images' );

if ( $images ) {
    echo '<ul class="project-gallery">';

    foreach ( $images as $image ) {
        printf(
            '<li><img src="%s" alt="%s" width="%d" height="%d" /></li>',
            esc_url( $image['sizes']['medium_large'] ),
            esc_attr( $image['alt'] ),
            (int) $image['sizes']['medium_large-width'],
            (int) $image['sizes']['medium_large-height']
        );
    }

    echo '</ul>';
}
