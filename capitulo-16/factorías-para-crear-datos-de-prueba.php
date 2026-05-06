class Test_Portfolio_Queries extends WP_UnitTestCase {

    /** @var int[] IDs de los posts de portfolio creados en el test */
    private array $post_ids = [];

    public function set_up(): void {
        parent::set_up();

        // Crear posts de prueba con metadatos
        $this->post_ids = $this->factory()->post->create_many( 10, [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );

        // Añadir metadatos específicos a algunos posts
        update_post_meta( $this->post_ids[0], '_npe_is_featured', '1' );
        update_post_meta( $this->post_ids[1], '_npe_is_featured', '1' );
        update_post_meta( $this->post_ids[2], '_npe_client_name', 'Cliente A' );
    }

    public function test_get_featured_returns_only_featured_projects(): void {
        $query = new \NinjaPortfolio\Queries\PortfolioQuery() // Ver implementación en cap. 19;
        $featured = $query->get_featured( 10 );

        $this->assertCount( 2, $featured );

        foreach ( $featured as $post ) {
            $this->assertEquals(
                '1',
                get_post_meta( $post->ID, '_npe_is_featured', true ),
                'Todos los posts devueltos deben tener el meta _npe_is_featured = 1'
            );
        }
    }

    public function test_get_by_client_returns_correct_posts(): void {
        $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // Ver implementación en cap. 19;
        $result = $query->get_by_client( 'Cliente A' );

        $this->assertCount( 1, $result );
        $this->assertEquals(
            $this->post_ids[2],
            $result[0]->ID
        );
    }

    public function test_query_excludes_drafts(): void {
        // Crear un post en estado draft
        $draft_id = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'draft',
        ] );

        $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // Ver implementación en cap. 19;
        $all    = $query->get_all( 100 );

        $ids = wp_list_pluck( $all, 'ID' );
        $this->assertNotContains( $draft_id, $ids );
    }
}
