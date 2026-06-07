function get_posts_by_ids( array $ids ): array {
    global $wpdb;

    if ( empty( $ids ) ) {
        return [];
    }

    // Build as many %d placeholders as there are elements in the array
    $placeholders = implode( ', ', array_fill( 0, count( $ids ), '%d' ) );

    // array_values ensures sequential indexes; array_merge
    // passes the IDs as individual arguments to prepare()
    $query = $wpdb->prepare(
        "SELECT ID, post_title FROM {$wpdb->posts}
         WHERE ID IN ({$placeholders}) AND post_status = %s",
        ...array_merge( array_values( $ids ), [ 'publish' ] )
    );

    return $wpdb->get_results( $query );
}
