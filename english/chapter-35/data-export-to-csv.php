add_action( 'admin_post_ninja_lms_export_completions', function(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }

    check_admin_referer( 'ninja_lms_export' );

    $completions = ninja_get_course_completions_last_month();

    if ( empty( $completions ) ) {
        wp_redirect( admin_url( 'admin.php?page=ninja-lms-reports&notice=no_data' ) );
        exit;
    }

    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename="completions-' . date( 'Y-m-d' ) . '.csv"' );
    header( 'Pragma: no-cache' );

    $output = fopen( 'php://output', 'w' );
    fprintf( $output, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ); // BOM for Excel

    fputcsv( $output, [ 'User ID', 'Name', 'Email', 'Course', 'Date' ] );

    foreach ( $completions as $row ) {
        $user   = get_userdata( $row['user_id'] );
        $course = get_the_title( $row['course_id'] );

        fputcsv( $output, [
            $row['user_id'],
            $user ? $user->display_name : '(deleted)',
            $user ? $user->user_email   : '',
            $course,
            wp_date( 'd/m/Y H:i', $row['completed_at'] ),
        ] );
    }

    fclose( $output );
    exit;
} );
