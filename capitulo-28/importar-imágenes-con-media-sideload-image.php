// Asegurarse de que las funciones de media están disponibles
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$image_url = esc_url_raw( $data['imagen_url'] );

if ( ! empty( $image_url ) ) {
    $attachment_id = media_sideload_image( $image_url, $post_id, null, 'id' );

    if ( ! is_wp_error( $attachment_id ) ) {
        set_post_thumbnail( $post_id, $attachment_id );
    } else {
        WP_CLI::warning( "No se pudo importar imagen para post {$post_id}: " . $attachment_id->get_error_message() );
    }
}
