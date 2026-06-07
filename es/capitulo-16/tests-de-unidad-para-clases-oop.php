// tests/test-portfolio-cpt.php

use NinjaPortfolio\PostTypes\Portfolio;

class Test_Portfolio extends WP_UnitTestCase {

    private Portfolio $cpt;

    public function set_up(): void {
        parent::set_up();
        $this->cpt = new Portfolio();
        $this->cpt->register();
    }

    public function test_post_type_is_registered(): void {
        $this->assertTrue(
            post_type_exists( 'portfolio' ),
            'El CPT portfolio debe estar registrado.'
        );
    }

    public function test_post_type_is_public(): void {
        $post_type = get_post_type_object( 'portfolio' );
        $this->assertTrue( $post_type->public );
    }

    public function test_post_type_supports_title_and_editor(): void {
        $supports = get_all_post_type_supports( 'portfolio' );
        $this->assertArrayHasKey( 'title', $supports );
        $this->assertArrayHasKey( 'editor', $supports );
        $this->assertArrayHasKey( 'thumbnail', $supports );
    }

    public function test_taxonomy_is_registered(): void {
        $this->assertTrue(
            taxonomy_exists( 'portfolio-category' ),
            'La taxonomía portfolio-category debe estar registrada.'
        );
    }

    public function test_taxonomy_is_associated_with_portfolio(): void {
        $taxonomies = get_object_taxonomies( 'portfolio' );
        $this->assertContains( 'portfolio-category', $taxonomies );
    }
}
