public function test_featured_query_uses_meta_key_index(): void {
    // Enable SAVEQUERIES only in this test
    if ( ! defined( 'SAVEQUERIES' ) ) {
        define( 'SAVEQUERIES', true );
    }

    global $wpdb;
    $wpdb->queries = [];

    $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // See implementation in ch. 19;
    $query->get_featured( 6 );

    // Verify that a query was executed with the correct meta_key
    $executed_sqls = wp_list_pluck( $wpdb->queries, 0 );
    $featured_query = array_filter( $executed_sqls, function( string $sql ): bool {
        return str_contains( $sql, '_npe_is_featured' );
    } );

    $this->assertNotEmpty(
        $featured_query,
        'The featured query must filter by _npe_is_featured.'
    );
}
