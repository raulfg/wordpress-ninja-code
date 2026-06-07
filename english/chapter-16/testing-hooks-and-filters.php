class Test_Portfolio_Hooks extends WP_UnitTestCase {

    public function test_save_post_hook_is_registered(): void {
        $cpt = new \NinjaPortfolio\PostTypes\Portfolio();
        $cpt->register();

        // Verify that the hook is connected
        $priority = has_action( 'save_post_portfolio', [ $cpt, 'save_meta' ] );
        $this->assertNotFalse( $priority, 'The save_post_portfolio hook must be registered.' );
    }

    public function test_save_meta_fields_saves_client_name(): void {
        $cpt     = new \NinjaPortfolio\PostTypes\Portfolio();
        $post_id = $this->factory()->post->create( [ 'post_type' => 'portfolio' ] );

        // Simulate the form POST
        $_POST['_npe_client_name']  = 'Test client';
        $_POST['ninjatheme_portfolio_nonce']   = wp_create_nonce( 'ninjatheme_portfolio_save' );

        $cpt->save_meta( $post_id );

        $saved = get_post_meta( $post_id, '_npe_client_name', true );
        $this->assertEquals( 'Test client', $saved );
    }

    public function test_save_meta_fields_rejects_invalid_nonce(): void {
        $cpt     = new \NinjaPortfolio\PostTypes\Portfolio();
        $post_id = $this->factory()->post->create( [ 'post_type' => 'portfolio' ] );

        $_POST['_npe_client_name'] = 'Malicious data';
        $_POST['ninjatheme_portfolio_nonce']  = 'invalid_nonce';

        $cpt->save_meta( $post_id );

        // With an invalid nonce, the meta MUST NOT be saved
        $saved = get_post_meta( $post_id, '_npe_client_name', true );
        $this->assertEmpty( $saved );
    }
}
