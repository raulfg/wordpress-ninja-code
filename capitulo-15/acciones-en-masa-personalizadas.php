add_filter(
    'bulk_actions-edit-portfolio',
    function( array $actions ): array {
        $actions['mark_featured']   = __( 'Marcar como destacado', 'ninja-portfolio' );
        $actions['unmark_featured'] = __( 'Quitar de destacados', 'ninja-portfolio' );
        return $actions;
    }
);

add_filter(
    'handle_bulk_actions-edit-portfolio',
    function( string $redirect_url, string $action, array $post_ids ): string {
        if ( ! in_array( $action, [ 'mark_featured', 'unmark_featured' ], true ) ) {
            return $redirect_url;
        }

        $value   = 'mark_featured' === $action ? '1' : '';
        $updated = 0;

        foreach ( $post_ids as $post_id ) {
            if ( ! current_user_can( 'edit_post', (int) $post_id ) ) {
                continue;
            }
            update_post_meta( (int) $post_id, '_npe_is_featured', $value );
            $updated++;
        }

        return add_query_arg(
            [ 'bulk_featured_updated' => $updated ],
            $redirect_url
        );
    },
    10,
    3
);

add_action( 'admin_notices', function(): void {
    $screen = get_current_screen();

    if ( ! $screen || 'edit-portfolio' !== $screen->id ) {
        return;
    }

    if ( isset( $_GET['bulk_featured_updated'] ) ) {
        $count = (int) $_GET['bulk_featured_updated'];
        printf(
            '<div class="notice notice-success is-dismissible"><p>%s</p></div>',
            esc_html( sprintf(
                _n(
                    '%d proyecto actualizado.',
                    '%d proyectos actualizados.',
                    $count,
                    'ninja-portfolio'
                ),
                $count
            ) )
        );
    }
} );
