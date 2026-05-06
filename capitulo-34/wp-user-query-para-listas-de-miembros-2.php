function ninja_export_members_csv(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Permisos insuficientes.', 'ninjatheme' ) );
    }

    check_admin_referer( 'ninja_export_members' );

    $query = new WP_User_Query( [
        'meta_key'     => '_ninja_membership_plan',
        'meta_compare' => 'EXISTS',
        'number'       => -1,
    ] );

    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=miembros-' . date( 'Y-m-d' ) . '.csv' );

    $output = fopen( 'php://output', 'w' );
    fputcsv( $output, [ 'ID', 'Email', 'Nombre', 'Plan', 'Inicio', 'Expira' ] );

    foreach ( $query->get_results() as $user ) {
        fputcsv( $output, [
            $user->ID,
            $user->user_email,
            $user->display_name,
            get_user_meta( $user->ID, '_ninja_membership_plan', true ),
            get_user_meta( $user->ID, '_ninja_membership_start', true ),
            get_user_meta( $user->ID, '_ninja_membership_expires', true ),
        ] );
    }

    fclose( $output );
    exit;
}
