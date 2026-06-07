<?php
namespace NinjaPortfolio\REST;

class PortfolioController extends \WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'ninjatheme/v1';
        $this->rest_base = 'portfolio';

        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes(): void
    {
        // GET /wp-json/ninjatheme/v1/portfolio
        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_items' ],
                'permission_callback' => '__return_true',
                'args'                => $this->get_collection_params(),
            ],
        ] );

        // GET /wp-json/ninjatheme/v1/portfolio/{id}
        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>\d+)', [
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
                    '_embed' => [
                        'description' => 'Incrustar recursos relacionados (thumbnail).',
                        'type'        => 'boolean',
                        'default'     => false,
                    ],
                ],
            ],
        ] );

        // GET /wp-json/ninjatheme/v1/portfolio/featured
        register_rest_route( $this->namespace, '/' . $this->rest_base . '/featured', [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_featured' ],
                'permission_callback' => '__return_true',
                'args'                => [
                    'limit' => [
                        'default'           => 6,
                        'sanitize_callback' => 'absint',
                        'validate_callback' => fn( $v ) => $v > 0 && $v <= 24,
                    ],
                ],
            ],
        ] );
    }

    public function get_items_permissions_check( \WP_REST_Request $request ): bool|\WP_Error
    {
        return true; // Lectura pública
    }

    public function get_item_permissions_check( \WP_REST_Request $request ): bool|\WP_Error
    {
        $post = get_post( $request->get_param( 'id' ) );

        if ( ! $post || 'portfolio' !== $post->post_type ) {
            return new \WP_Error(
                'rest_not_found',
                __( 'Proyecto no encontrado.', 'ninja-portfolio' ),
                [ 'status' => 404 ]
            );
        }

        if ( 'publish' !== $post->post_status && ! current_user_can( 'edit_post', $post->ID ) ) {
            return new \WP_Error(
                'rest_forbidden',
                __( 'No tienes permiso para ver este proyecto.', 'ninja-portfolio' ),
                [ 'status' => 403 ]
            );
        }

        return true;
    }

    public function get_items( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error
    {
        $per_page = $request->get_param( 'per_page' ) ?? 12;
        $page     = $request->get_param( 'page' ) ?? 1;
        $category = $request->get_param( 'category' );
        $search   = $request->get_param( 'search' );
        $orderby  = $request->get_param( 'orderby' ) ?? 'date';
        $order    = strtoupper( $request->get_param( 'order' ) ?? 'DESC' );

        $args = [
            'post_type'      => 'portfolio',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'orderby'        => in_array( $orderby, [ 'date', 'title', 'menu_order' ], true ) ? $orderby : 'date',
            'order'          => in_array( $order, [ 'ASC', 'DESC' ], true ) ? $order : 'DESC',
            'no_found_rows'  => false, // Necesitamos el total para paginación
        ];

        if ( $category ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'portfolio-category',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $category ),
                ],
            ];
        }

        if ( $search ) {
            $args['s'] = sanitize_text_field( $search );
        }

        $query = new \WP_Query( $args );

        $items = array_map( [ $this, 'prepare_item_for_response' ], $query->posts );

        $response = new \WP_REST_Response( array_values( $items ), 200 );
        $response->header( 'X-WP-Total',      $query->found_posts );
        $response->header( 'X-WP-TotalPages', $query->max_num_pages );

        return $response;
    }

    public function get_item( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error
    {
        $post = get_post( $request->get_param( 'id' ) );

        if ( ! $post ) {
            return new \WP_Error( 'rest_not_found', __( 'Proyecto no encontrado.', 'ninja-portfolio' ), [ 'status' => 404 ] );
        }

        return new \WP_REST_Response( $this->prepare_item_for_response( $post ), 200 );
    }

    public function get_featured( \WP_REST_Request $request ): \WP_REST_Response
    {
        $limit    = $request->get_param( 'limit' );
        $cache_key = 'npe_featured_' . $limit;
        $cached    = get_transient( $cache_key );

        if ( false !== $cached ) {
            return new \WP_REST_Response( $cached, 200 );
        }

        $query = new \WP_Query( [
            'post_type'              => 'portfolio',
            'post_status'            => 'publish',
            'posts_per_page'         => $limit,
            'meta_key'               => '_npe_is_featured',
            'meta_value'             => '1',
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
        ] );

        $items = array_map( [ $this, 'prepare_item_for_response' ], $query->posts );
        $data  = array_values( $items );

        set_transient( $cache_key, $data, HOUR_IN_SECONDS );

        return new \WP_REST_Response( $data, 200 );
    }

    public function prepare_item_for_response( \WP_Post $post ): array
    {
        $categories = get_the_terms( $post->ID, 'portfolio-category' );
        $categories = ( $categories && ! is_wp_error( $categories ) )
            ? array_map( fn( \WP_Term $t ) => [
                'id'   => $t->term_id,
                'name' => $t->name,
                'slug' => $t->slug,
                'url'  => get_term_link( $t ),
            ], $categories )
            : [];

        $technologies = get_the_terms( $post->ID, 'portfolio-technology' );
        $technologies = ( $technologies && ! is_wp_error( $technologies ) )
            ? wp_list_pluck( $technologies, 'name' )
            : [];

        return [
            'id'          => $post->ID,
            'title'       => get_the_title( $post ),
            'slug'        => $post->post_name,
            'excerpt'     => wp_strip_all_tags( get_the_excerpt( $post ) ),
            'url'         => get_permalink( $post ),
            'thumbnail'   => [
                'full'   => get_the_post_thumbnail_url( $post, 'full' ) ?: null,
                'large'  => get_the_post_thumbnail_url( $post, 'large' ) ?: null,
                'medium' => get_the_post_thumbnail_url( $post, 'medium' ) ?: null,
            ],
            'categories'  => $categories,
            'technologies' => $technologies,
            'meta'        => [
                'project_url' => get_post_meta( $post->ID, '_npe_project_url', true ) ?: null,
                'client'      => get_post_meta( $post->ID, '_npe_client_name', true ) ?: null,
                'year'        => (int) get_post_meta( $post->ID, '_npe_project_year', true ) ?: null,
                'featured'    => (bool) get_post_meta( $post->ID, '_npe_is_featured', true ),
            ],
            'date'        => $post->post_date,
            'modified'    => $post->post_modified,
        ];
    }

    public function get_collection_params(): array
    {
        return [
            'page'     => [ 'default' => 1, 'sanitize_callback' => 'absint' ],
            'per_page' => [
                'default'           => 12,
                'sanitize_callback' => 'absint',
                'validate_callback' => fn( $v ) => $v > 0 && $v <= 100,
            ],
            'category' => [ 'sanitize_callback' => 'sanitize_text_field' ],
            'search'   => [ 'sanitize_callback' => 'sanitize_text_field' ],
            'orderby'  => [
                'default'           => 'date',
                'validate_callback' => fn( $v ) => in_array( $v, [ 'date', 'title', 'menu_order' ], true ),
            ],
            'order'    => [
                'default'           => 'desc',
                'validate_callback' => fn( $v ) => in_array( strtoupper( $v ), [ 'ASC', 'DESC' ], true ),
            ],
        ];
    }
}
