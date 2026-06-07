// Extender WP_REST_Controller para crear endpoints propios (cap. 20)
class Ninja_Portfolio_REST_Controller extends WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'ninjatheme/v1';
        $this->rest_base = 'portfolio';
    }

    public function register_routes(): void
    {
        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_items' ],
                'permission_callback' => '__return_true',
            ],
        ] );
    }

    public function get_items( WP_REST_Request $request ): WP_REST_Response
    {
        // ...
    }
}
