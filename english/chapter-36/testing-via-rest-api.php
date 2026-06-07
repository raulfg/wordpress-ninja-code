class Test_Portfolio_Abilities_REST extends WP_REST_TestCase {

    public function test_get_projects_endpoint_is_public(): void {
        $request  = new WP_REST_Request( 'GET', '/wp-abilities/v1/ninja-portfolio/get-projects/run' );
        $response = rest_get_server()->dispatch( $request );

        $this->assertEquals( 200, $response->get_status() );
    }

    public function test_create_project_endpoint_requires_auth(): void {
        $request = new WP_REST_Request(
            'POST',
            '/wp-abilities/v1/ninja-portfolio/create-project/run'
        );
        $request->set_body_params( [ 'title' => 'Test' ] );

        $response = rest_get_server()->dispatch( $request );

        $this->assertEquals( 403, $response->get_status() );
    }

    public function test_create_project_endpoint_works_with_editor(): void {
        wp_set_current_user( $this->factory()->user->create( [ 'role' => 'editor' ] ) );

        $request = new WP_REST_Request(
            'POST',
            '/wp-abilities/v1/ninja-portfolio/create-project/run'
        );
        $request->set_body_params( [ 'title' => 'REST Project' ] );

        $response = rest_get_server()->dispatch( $request );

        $this->assertEquals( 200, $response->get_status() );
        $data = $response->get_data();
        $this->assertTrue( $data['success'] );
    }

    public function test_abilities_list_filters_by_permission(): void {
        // User without permissions: should only see public Abilities
        wp_set_current_user( 0 ); // Unauthenticated

        $request  = new WP_REST_Request( 'GET', '/wp-abilities/v1/abilities' );
        $response = rest_get_server()->dispatch( $request );
        $abilities = $response->get_data();

        $names = array_column( $abilities, 'name' );

        // Write Abilities must not appear for users without permissions
        $this->assertNotContains( 'ninja-portfolio/create-project', $names );
        $this->assertNotContains( 'ninja-portfolio/delete-project', $names );
        // Read Abilities should appear
        $this->assertContains( 'ninja-portfolio/get-projects', $names );
    }
}
