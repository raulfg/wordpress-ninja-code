class Test_Portfolio_Queries extends WP_UnitTestCase {

    /** @var int[] IDs of the portfolio posts created in the test */
    private array $post_ids = [];

    public function set_up(): void {
        parent::set_up();

        // Create test posts with metadata
        $this->post_ids = $this->factory()->post->create_many( 10, [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );

        // Add specific metadata to some posts
        update_post_meta( $this->post_ids[0], '_npe_is_featured', '1' );
        update_post_meta( $this->post_ids[1], '_npe_is_featured', '1' );
        update_post_meta( $this->post_ids[2], '_npe_client_name', 'Client A' );
    }

    public function test_get_featured_returns_only_featured_projects(): void {
        $query = new \NinjaPortfolio\Queries\PortfolioQuery() // See implementation in ch. 19;
        $featured = $query->get_featured( 10 );

        $this->assertCount( 2, $featured );

        foreach ( $featured as $post ) {
            $this->assertEquals(
                '1',
                get_post_meta( $post->ID, '_npe_is_featured', true ),
                'All returned posts must have the meta _npe_is_featured = 1'
            );
        }
    }

    public function test_get_by_client_returns_correct_posts(): void {
        $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // See implementation in ch. 19;
        $result = $query->get_by_client( 'Client A' );

        $this->assertCount( 1, $result );
        $this->assertEquals(
            $this->post_ids[2],
            $result[0]->ID
        );
    }

    public function test_query_excludes_drafts(): void {
        // Create a post in draft status
        $draft_id = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'draft',
        ] );

        $query  = new \NinjaPortfolio\Queries\PortfolioQuery() // See implementation in ch. 19;
        $all    = $query->get_all( 100 );

        $ids = wp_list_pluck( $all, 'ID' );
        $this->assertNotContains( $draft_id, $ids );
    }
}
