<?php
// tests/test-portfolio-endpoint.php

class Test_Portfolio_Endpoint extends WP_UnitTestCase {

    private WP_REST_Server $server;

    public function set_up(): void {
        parent::set_up();
        global $wp_rest_server;
        $this->server = $wp_rest_server = new WP_REST_Server();
        do_action( 'rest_api_init' );
    }

    public function test_portfolio_endpoint_returns_only_published(): void {
        // Create test posts
        $published = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
            'post_title'  => 'Published project',
        ] );

        $draft = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'draft',
            'post_title'  => 'Draft project',
        ] );

        $request  = new WP_REST_Request( 'GET', '/ninja-portfolio/v1/projects' );
        $response = $this->server->dispatch( $request );

        $this->assertEquals( 200, $response->get_status() );

        $data = $response->get_data();
        $ids  = wp_list_pluck( $data, 'id' );

        $this->assertContains( $published, $ids );
        $this->assertNotContains( $draft, $ids );
    }

    public function test_featured_projects_filter(): void {
        $featured = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );
        update_post_meta( $featured, '_npe_is_featured', '1' );

        $regular = $this->factory()->post->create( [
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
        ] );

        $request = new WP_REST_Request( 'GET', '/ninja-portfolio/v1/projects' );
        $request->set_param( 'featured', true );
        $response = $this->server->dispatch( $request );

        $data = $response->get_data();
        $ids  = wp_list_pluck( $data, 'id' );

        $this->assertContains( $featured, $ids );
        $this->assertNotContains( $regular, $ids );
    }
}
