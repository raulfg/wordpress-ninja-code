class Test_Portfolio_Hooks extends WP_UnitTestCase {

    public function test_save_post_hook_is_registered(): void {
        $cpt = new \NinjaPortfolio\PostTypes\Portfolio();
        $cpt->register();

        // Verificar que el hook está conectado
        $priority = has_action( 'save_post_portfolio', [ $cpt, 'save_meta' ] );
        $this->assertNotFalse( $priority, 'El hook save_post_portfolio debe estar registrado.' );
    }

    public function test_save_meta_fields_saves_client_name(): void {
        $cpt     = new \NinjaPortfolio\PostTypes\Portfolio();
        $post_id = $this->factory()->post->create( [ 'post_type' => 'portfolio' ] );

        // Simular el POST del formulario
        $_POST['_npe_client_name']  = 'Cliente de prueba';
        $_POST['ninjatheme_portfolio_nonce']   = wp_create_nonce( 'ninjatheme_portfolio_save' );

        $cpt->save_meta( $post_id );

        $saved = get_post_meta( $post_id, '_npe_client_name', true );
        $this->assertEquals( 'Cliente de prueba', $saved );
    }

    public function test_save_meta_fields_rejects_invalid_nonce(): void {
        $cpt     = new \NinjaPortfolio\PostTypes\Portfolio();
        $post_id = $this->factory()->post->create( [ 'post_type' => 'portfolio' ] );

        $_POST['_npe_client_name'] = 'Datos maliciosos';
        $_POST['ninjatheme_portfolio_nonce']  = 'nonce_invalido';

        $cpt->save_meta( $post_id );

        // Con nonce inválido, el meta NO debe guardarse
        $saved = get_post_meta( $post_id, '_npe_client_name', true );
        $this->assertEmpty( $saved );
    }
}
