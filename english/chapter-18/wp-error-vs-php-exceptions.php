// At the boundary between your code and WordPress
add_action( 'wp_ajax_my_action', function (): void {
    try {
        $result = my_internal_service->execute();
        wp_send_json_success( $result );
    } catch ( MyDomainException $e ) {
        wp_send_json_error(
            new WP_Error( 'domain_error', $e->getMessage() ),
            400
        );
    } catch ( \Throwable $e ) {
        error_log( '[my-plugin] Unexpected error: ' . $e->getMessage() );
        wp_send_json_error(
            new WP_Error( 'internal_error', __( 'Internal server error.', 'my-plugin' ) ),
            500
        );
    }
} );
