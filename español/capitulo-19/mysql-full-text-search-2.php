/**
 * Búsqueda full-text con ranking por relevancia.
 *
 * @param string $search_term Término de búsqueda.
 * @param string $post_type   Tipo de post a buscar.
 * @param int    $limit       Número máximo de resultados.
 * @return array Array de posts ordenados por relevancia.
 */
function ninja_fulltext_search( string $search_term, string $post_type = 'post', int $limit = 10 ): array {
    global $wpdb;

    // Sanitizar el término — prepare() gestiona el escapado SQL
    $search_term = sanitize_text_field( $search_term );

    if ( empty( $search_term ) ) {
        return [];
    }

    $results = $wpdb->get_results( $wpdb->prepare(
        "SELECT p.ID, p.post_title,
                MATCH(p.post_title, p.post_content) AGAINST(%s IN NATURAL LANGUAGE MODE) AS relevance
         FROM {$wpdb->posts} p
         WHERE p.post_status = 'publish'
           AND p.post_type = %s
           AND MATCH(p.post_title, p.post_content) AGAINST(%s IN NATURAL LANGUAGE MODE)
         ORDER BY relevance DESC
         LIMIT %d",
        $search_term,
        $post_type,
        $search_term,
        $limit
    ) );

    return array_map( fn( $row ) => (int) $row->ID, $results );
}
