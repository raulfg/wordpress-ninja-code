/**
 * WP-CLI commands for NinjaTheme.
 */
class NinjaTheme_CLI_Command extends WP_CLI_Command {

    /**
     * Lists portfolio CPT posts with their publication status.
     *
     * ## OPTIONS
     *
     * [--status=<status>]
     * : Filter by status. Default: publish.
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
            WP_CLI::warning( "No posts found with status '{$status}'." );
            return;
        }

        $rows = array_map( function( $post ) {
            return [
                'ID'     => $post->ID,
                'Title'  => $post->post_title,
                'Status' => $post->post_status,
                'Date'   => $post->post_date,
            ];
        }, $posts );

        WP_CLI\Utils\format_items( 'table', $rows, [ 'ID', 'Title', 'Status', 'Date' ] );
    }
}
