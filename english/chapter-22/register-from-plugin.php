private function __construct()
{
    new Portfolio();
    new PortfolioCategory();
    new PortfolioTechnology();
    new REST\PortfolioController();

    add_action( 'init', [ $this, 'register_meta' ] );
    add_action( 'init', [ $this, 'register_blocks' ] );
    add_filter( 'block_categories_all', [ $this, 'register_block_category' ] );

    add_action( 'init', function(): void {
        load_plugin_textdomain( 'ninja-portfolio', false,
            dirname( plugin_basename( NPE_PLUGIN_DIR ) ) . '/languages' );
    } );
}

public function register_blocks(): void
{
    register_block_type( NPE_PLUGIN_DIR . 'blocks/portfolio-grid' );
}

public function register_block_category( array $categories ): array
{
    // Add a custom category in the block inserter
    array_unshift( $categories, [
        'slug'  => 'ninjatheme',
        'title' => __( 'NinjaTheme', 'ninja-portfolio' ),
        'icon'  => 'ninja',
    ] );

    return $categories;
}
