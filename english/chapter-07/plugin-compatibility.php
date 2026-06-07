register_block_type( 'ninjatheme/portfolio-recent', [
    'render_callback' => function( array $attributes ): string {
        $posts = get_posts( [
            'post_type'      => 'portfolio',
            'posts_per_page' => (int) ( $attributes['count'] ?? 3 ),
            'post_status'    => 'publish',
        ] );

        ob_start();
        foreach ( $posts as $post ) {
            // render each post
        }
        return ob_get_clean();
    },
    'attributes' => [
        'count' => [ 'type' => 'integer', 'default' => 3 ],
    ],
] );
