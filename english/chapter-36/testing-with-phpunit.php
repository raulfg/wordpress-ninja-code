// tests/test-portfolio-abilities.php

class Test_Portfolio_Abilities extends WP_UnitTestCase {

    private PortfolioAbilities $abilities;

    public function set_up(): void {
        parent::set_up();
        $this->abilities = new NinjaPortfolio\Abilities\PortfolioAbilities();

        // Fire ability registration so they are available
        do_action( 'wp_abilities_api_categories_init' );
        do_action( 'wp_abilities_api_init' );
    }

    public function test_get_projects_returns_only_published(): void {
        $published = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );
        $draft = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'draft',
        ] );

        $ability = wp_get_ability( 'ninja-portfolio/get-projects' );
        $result  = $ability->execute( [] );

        $ids = array_column( $result, 'id' );
        $this->assertContains( $published, $ids );
        $this->assertNotContains( $draft, $ids );
    }

    public function test_create_project_requires_edit_posts(): void {
        // User without permissions
        wp_set_current_user( $this->factory()->user->create( [ 'role' => 'subscriber' ] ) );

        $ability = wp_get_ability( 'ninja-portfolio/create-project' );

        // The permission_callback must deny access
        $this->assertFalse( $ability->check_permission() );
    }

    public function test_create_project_creates_post_with_meta(): void {
        wp_set_current_user( $this->factory()->user->create( [ 'role' => 'editor' ] ) );

        $ability = wp_get_ability( 'ninja-portfolio/create-project' );
        $result  = $ability->execute( [
            'title'    => 'Test project',
            'client'   => 'Test client',
            'year'     => 2024,
            'featured' => true,
        ] );

        $this->assertTrue( $result['success'] );
        $this->assertGreaterThan( 0, $result['id'] );

        // Verify the post was created correctly
        $post = get_post( $result['id'] );
        $this->assertEquals( 'Test project', $post->post_title );

        // Verify metadata was saved
        $this->assertEquals( 'Test client', get_post_meta( $result['id'], '_npe_client_name', true ) );
        $this->assertEquals( '1', get_post_meta( $result['id'], '_npe_is_featured', true ) );
    }

    public function test_get_project_by_slug(): void {
        $post_id = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
            'post_name'   => 'proyecto-test',
        ] );

        $ability = wp_get_ability( 'ninja-portfolio/get-project' );
        $result  = $ability->execute( [ 'slug' => 'proyecto-test' ] );

        $this->assertEquals( $post_id, $result['id'] );
        $this->assertEquals( get_permalink( $post_id ), $result['url'] );
    }
}
