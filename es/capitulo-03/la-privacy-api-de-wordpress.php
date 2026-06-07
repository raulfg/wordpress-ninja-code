// Registrar un exportador de datos personales
add_filter( 'wp_privacy_personal_data_exporters', function( $exporters ) {
    $exporters['ninja-portfolio'] = [
        'exporter_friendly_name' => __( 'Ninja Portfolio Pro', 'ninja-portfolio' ),
        'callback'               => 'ninja_portfolio_privacy_exporter',
    ];
    return $exporters;
} );

function ninja_portfolio_privacy_exporter( string $email_address, int $page = 1 ): array {
    $user = get_user_by( 'email', $email_address );
    $data = [];

    if ( $user ) {
        $submissions = get_posts( [
            'post_type'  => 'portfolio_submission',
            'author'     => $user->ID,
            'fields'     => 'ids',
        ] );

        foreach ( $submissions as $post_id ) {
            $data[] = [
                'group_id'    => 'portfolio-submissions',
                'group_label' => __( 'Envíos de portfolio', 'ninja-portfolio' ),
                'item_id'     => "submission-{$post_id}",
                'data'        => [
                    [ 'name' => __( 'Título', 'ninja-portfolio' ), 'value' => get_the_title( $post_id ) ],
                    [ 'name' => __( 'Fecha', 'ninja-portfolio' ), 'value' => get_the_date( '', $post_id ) ],
                ],
            ];
        }
    }

    return [ 'data' => $data, 'done' => true ];
}
