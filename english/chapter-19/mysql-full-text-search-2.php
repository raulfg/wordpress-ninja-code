/**
 * Full-text search with relevance ranking.
 *
 * @param string $search_term Search term.
 * @param string $post_type   Post type to search.
 * @param int    $limit       Maximum number of results.
 * @return array Array of posts ordered by relevance.
 */
function ninja_fulltext_search( string $search_term, string $post_type = 'post', int $limit = 10 ): array {
    global $wpdb;

    // Sanitize the term — prepare() handles SQL escaping
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
