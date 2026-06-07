class NinjaTheme_Portfolio_Sitemap extends WP_Sitemaps_Provider {
    public function __construct() {
        $this->name        = 'portfolio-items';
        $this->object_type = 'portfolio';
    }

    public function get_url_list( int $page_num, string $object_subtype = '' ): array {
        $posts = get_posts( [
            'post_type'      => 'portfolio',
            'posts_per_page' => wp_sitemaps_get_max_urls( $this->object_type ),
            'paged'          => $page_num,
        ] );

        return array_map( fn( WP_Post $post ) => [
            'loc'     => get_permalink( $post ),
            'lastmod' => get_the_modified_date( DATE_W3C, $post ),
        ], $posts );
    }

    public function get_max_num_pages( string $object_subtype = '' ): int {
        return (int) ceil( wp_count_posts( 'portfolio' )->publish / wp_sitemaps_get_max_urls( $this->object_type ) );
    }
}

add_action( 'init', function(): void {
    wp_sitemaps_get_server()->add_provider( new NinjaTheme_Portfolio_Sitemap() );
} );
