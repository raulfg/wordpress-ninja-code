function obtener_posts_por_ids( array $ids ): array {
    global $wpdb;

    if ( empty( $ids ) ) {
        return [];
    }

    // Construir tantos %d como elementos haya en el array
    $placeholders = implode( ', ', array_fill( 0, count( $ids ), '%d' ) );

    // array_values garantiza índices secuenciales; array_merge
    // pasa los IDs como argumentos individuales a prepare()
    $consulta = $wpdb->prepare(
        "SELECT ID, post_title FROM {$wpdb->posts}
         WHERE ID IN ({$placeholders}) AND post_status = %s",
        ...array_merge( array_values( $ids ), [ 'publish' ] )
    );

    return $wpdb->get_results( $consulta );
}
