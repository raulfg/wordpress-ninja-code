<?php

namespace NinjaTheme\REST;

class Portfolio_Controller extends \WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'ninjatheme/v1';
        $this->rest_base = 'portfolio';
    }

    public function register_routes(): void
    {
        // Collection: GET /wp-json/ninjatheme/v1/portfolio
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_items' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ],
            ]
        );

        // Single item: GET /wp-json/ninjatheme/v1/portfolio/{id}
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_item' ],
                    'permission_callback' => [ $this, 'get_item_permissions_check' ],
                    'args'                => [
                        'id' => [
                            'required'          => true,
                            'validate_callback' => fn( $v ) => is_numeric( $v ) && $v > 0,
                            'sanitize_callback' => 'absint',
                        ],
                    ],
                ],
            ]
        );
    }

    public function get_items_permissions_check( \WP_REST_Request $request ): bool|\WP_Error
    {
        // Public read access
        return true;
    }

    public function get_item_permissions_check( \WP_REST_Request $request ): bool|\WP_Error
    {
        $post = get_post( $request->get_param( 'id' ) );

        if ( ! $post || 'portfolio' !== $post->post_type ) {
            return new \WP_Error(
                'rest_portfolio_invalid_id',
                'Invalid project ID.',
                [ 'status' => 404 ]
            );
        }

        return 'publish' === $post->post_status || current_user_can( 'edit_post', $post->ID );
    }

    public function get_items( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error
    {
        $per_page = $request->get_param( 'per_page' ) ?? 10;
        $page     = $request->get_param( 'page' ) ?? 1;

        $query = new \WP_Query( [
            'post_type'      => 'portfolio',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
        ] );

        $items = array_map( [ $this, 'prepare_item_for_response' ], $query->posts );

        $response = new \WP_REST_Response( $items, 200 );
        $response->header( 'X-WP-Total',      $query->found_posts );
        $response->header( 'X-WP-TotalPages', $query->max_num_pages );

        return $response;
    }

    public function get_item( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error
    {
        $post = get_post( $request->get_param( 'id' ) );

        if ( ! $post ) {
            return new \WP_Error( 'rest_not_found', 'Project not found.', [ 'status' => 404 ] );
        }

        return new \WP_REST_Response( $this->prepare_item_for_response( $post ), 200 );
    }

    /**
     * Transforms a WP_Post into the response array.
     * Separating this method makes it easy to reuse in get_items and get_item.
     */
    public function prepare_item_for_response( \WP_Post $post ): array
    {
        return [
            'id'          => $post->ID,
            'title'       => $post->post_title,
            'slug'        => $post->post_name,
            'link'        => get_permalink( $post ),
            'excerpt'     => wp_strip_all_tags( get_the_excerpt( $post ) ),
            'thumbnail'   => get_the_post_thumbnail_url( $post, 'large' ) ?: null,
            'categories'  => $this->get_item_terms( $post->ID, 'portfolio-category' ),
            'project_url' => get_post_meta( $post->ID, '_npe_project_url', true ) ?: null,
            'client'      => get_post_meta( $post->ID, '_npe_client_name', true ) ?: null,
            'year'        => (int) get_post_meta( $post->ID, '_ano_proyecto', true ) ?: null,
        ];
    }

    private function get_item_terms( int $post_id, string $taxonomy ): array
    {
        $terms = get_the_terms( $post_id, $taxonomy );

        if ( ! $terms || is_wp_error( $terms ) ) {
            return [];
        }

        return array_map( fn( \WP_Term $t ) => [
            'id'   => $t->term_id,
            'name' => $t->name,
            'slug' => $t->slug,
            'link' => get_term_link( $t ),
        ], $terms );
    }

    public function get_collection_params(): array
    {
        return [
            'page'     => [
                'default'           => 1,
                'sanitize_callback' => 'absint',
            ],
            'per_page' => [
                'default'           => 10,
                'sanitize_callback' => 'absint',
            ],
        ];
    }
}
