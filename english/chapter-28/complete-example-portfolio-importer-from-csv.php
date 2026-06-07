/**
 * Imports portfolio CPT posts from a CSV file.
 *
 * ## OPTIONS
 *
 * --file=<file>
 * : Path to the CSV file. Must have headers: title,description,client,project_url
 *
 * [--dry-run]
 * : Simulates the import without creating posts.
 *
 * ## EXAMPLES
 *
 *     wp ninjatheme portfolio import --file=data.csv
 *     wp ninjatheme portfolio import --file=data.csv --dry-run
 */
public function portfolio_import( $args, $assoc_args ) {
    $file    = \WP_CLI\Utils\get_flag_value( $assoc_args, 'file', '' );
    $dry_run = \WP_CLI\Utils\get_flag_value( $assoc_args, 'dry-run', false );

    if ( empty( $file ) || ! file_exists( $file ) ) {
        WP_CLI::error( "The file '{$file}' does not exist or was not specified." );
    }

    $handle = fopen( $file, 'r' );
    $headers = fgetcsv( $handle );
    $rows = [];

    while ( ( $row = fgetcsv( $handle ) ) !== false ) {
        $rows[] = array_combine( $headers, $row );
    }
    fclose( $handle );

    if ( empty( $rows ) ) {
        WP_CLI::warning( 'The CSV file is empty or has no data rows.' );
        return;
    }

    if ( $dry_run ) {
        WP_CLI::log( sprintf( 'Dry run: %d rows would be processed.', count( $rows ) ) );
        return;
    }

    $progress = \WP_CLI\Utils\make_progress_bar(
        'Importing portfolio posts',
        count( $rows )
    );

    $created = 0;
    $errors  = 0;

    foreach ( $rows as $index => $row ) {
        $post_id = wp_insert_post( [
            'post_title'   => sanitize_text_field( $row['titulo'] ),
            'post_content' => wp_kses_post( $row['descripcion'] ),
            'post_type'    => 'portfolio',
            'post_status'  => 'publish',
        ], true );

        if ( is_wp_error( $post_id ) ) {
            WP_CLI::warning( sprintf(
                'Row %d: error creating post — %s',
                $index + 2,
                $post_id->get_error_message()
            ) );
            $errors++;
        } else {
            update_post_meta( $post_id, '_portfolio_cliente', sanitize_text_field( $row['cliente'] ) );
            update_post_meta( $post_id, '_portfolio_url', esc_url_raw( $row['url_proyecto'] ) );
            $created++;
        }

        $progress->tick();
    }

    $progress->finish();

    WP_CLI::success( sprintf(
        'Import completed: %d posts created, %d errors.',
        $created,
        $errors
    ) );
}
