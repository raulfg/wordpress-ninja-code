/**
 * Comandos WP-CLI para NinjaTheme.
 */
class NinjaTheme_CLI_Command extends WP_CLI_Command {

    /**
     * Lista los posts del CPT portfolio con su estado de publicación.
     *
     * ## OPTIONS
     *
     * [--status=<status>]
     * : Filtrar por estado. Por defecto: publish.
     *
     * ## EXAMPLES
     *
     *     wp ninjatheme portfolio list
     *     wp ninjatheme portfolio list --status=draft
     *
     * @subcommand portfolio list
     */
    public function portfolio_list( $args, $assoc_args ) {
        $status = \WP_CLI\Utils\get_flag_value( $assoc_args, 'status', 'publish' );

        $posts = get_posts( [
            'post_type'      => 'portfolio',
            'post_status'    => $status,
            'posts_per_page' => -1,
        ] );

        if ( empty( $posts ) ) {
            WP_CLI::warning( "No se encontraron posts con estado '{$status}'." );
            return;
        }

        $rows = array_map( function( $post ) {
            return [
                'ID'     => $post->ID,
                'Título' => $post->post_title,
                'Estado' => $post->post_status,
                'Fecha'  => $post->post_date,
            ];
        }, $posts );

        WP_CLI\Utils\format_items( 'table', $rows, [ 'ID', 'Título', 'Estado', 'Fecha' ] );
    }
}
