// Generate the delete link with a nonce
$delete_url = wp_nonce_url(
    add_query_arg( [
        'action'  => 'ninja_delete_item',
        'item_id' => $item_id,
    ], admin_url( 'admin.php' ) ),
    'ninja_delete_item_' . $item_id
);

echo '<a href="' . esc_url( $delete_url ) . '">' . esc_html__( 'Delete', 'ninjatheme' ) . '</a>';

// Verify in the handler
add_action( 'admin_action_ninja_delete_item', function(): void {
    $item_id = absint( $_GET['item_id'] ?? 0 );

    check_admin_referer( 'ninja_delete_item_' . $item_id );

    if ( ! current_user_can( 'delete_posts' ) ) {
        wp_die( esc_html__( 'Insufficient permissions.', 'ninjatheme' ) );
    }

    // Perform the operation
    ninja_delete_item( $item_id );

    wp_redirect( admin_url( 'admin.php?page=ninja-items&deleted=1' ) );
    exit;
} );
