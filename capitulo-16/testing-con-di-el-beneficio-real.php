class PortfolioTest extends WP_UnitTestCase
{
    public function test_get_featured_returns_published_only(): void
    {
        $mock_cache = $this->createMock( CacheInterface::class );
        $mock_cache->method( 'get' )->willReturn( null );     // Caché vacía
        $mock_cache->method( 'set' )->willReturn( true );

        $portfolio = new Portfolio( $mock_cache );

        // Crear posts de prueba en la base de datos de test
        $published = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );

        $draft = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'draft',
        ] );

        $results = $portfolio->get_featured();

        $ids = wp_list_pluck( $results, 'ID' );
        $this->assertContains( $published, $ids );
        $this->assertNotContains( $draft, $ids );
    }
}
