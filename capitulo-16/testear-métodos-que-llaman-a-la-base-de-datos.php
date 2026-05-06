public function test_featured_query_uses_meta_key_index(): void {
    // Activar SAVEQUERIES solo en este test
    if ( ! defined( 'SAVEQUERIES' ) ) {
        define( 'SAVEQUERIES', true );
    }

    global $wpdb;
    $wpdb->queries = [];

    $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // Ver implementación en cap. 19;
    $query->get_featured( 6 );

    // Verificar que se ejecutó una query con el meta_key correcto
    $executed_sqls = wp_list_pluck( $wpdb->queries, 0 );
    $featured_query = array_filter( $executed_sqls, function( string $sql ): bool {
        return str_contains( $sql, '_npe_is_featured' );
    } );

    $this->assertNotEmpty(
        $featured_query,
        'La query de destacados debe filtrar por _npe_is_featured.'
    );
}
