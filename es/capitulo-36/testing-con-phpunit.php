// tests/test-portfolio-abilities.php

class Test_Portfolio_Abilities extends WP_UnitTestCase {

    private PortfolioAbilities $abilities;

    public function set_up(): void {
        parent::set_up();
        $this->abilities = new NinjaPortfolio\Abilities\PortfolioAbilities();

        // Disparar el registro de Abilities para que estén disponibles
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
        // Usuario sin permisos
        wp_set_current_user( $this->factory()->user->create( [ 'role' => 'subscriber' ] ) );

        $ability = wp_get_ability( 'ninja-portfolio/create-project' );

        // El permission_callback debe denegar el acceso
        $this->assertFalse( $ability->check_permission() );
    }

    public function test_create_project_creates_post_with_meta(): void {
        wp_set_current_user( $this->factory()->user->create( [ 'role' => 'editor' ] ) );

        $ability = wp_get_ability( 'ninja-portfolio/create-project' );
        $result  = $ability->execute( [
            'title'    => 'Proyecto de prueba',
            'client'   => 'Cliente de prueba',
            'year'     => 2024,
            'featured' => true,
        ] );

        $this->assertTrue( $result['success'] );
        $this->assertGreaterThan( 0, $result['id'] );

        // Verificar que el post se creó correctamente
        $post = get_post( $result['id'] );
        $this->assertEquals( 'Proyecto de prueba', $post->post_title );

        // Verificar que los metadatos se guardaron
        $this->assertEquals( 'Cliente de prueba', get_post_meta( $result['id'], '_npe_client_name', true ) );
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
