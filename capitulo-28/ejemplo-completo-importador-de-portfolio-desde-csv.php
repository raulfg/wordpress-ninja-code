/**
 * Importa posts del CPT portfolio desde un archivo CSV.
 *
 * ## OPTIONS
 *
 * --file=<file>
 * : Ruta al archivo CSV. Debe tener cabeceras: titulo,descripcion,cliente,url_proyecto
 *
 * [--dry-run]
 * : Simula la importación sin crear posts.
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
        WP_CLI::error( "El archivo '{$file}' no existe o no se especificó." );
    }

    $handle = fopen( $file, 'r' );
    $headers = fgetcsv( $handle );
    $rows = [];

    while ( ( $row = fgetcsv( $handle ) ) !== false ) {
        $rows[] = array_combine( $headers, $row );
    }
    fclose( $handle );

    if ( empty( $rows ) ) {
        WP_CLI::warning( 'El archivo CSV está vacío o no tiene filas de datos.' );
        return;
    }

    if ( $dry_run ) {
        WP_CLI::log( sprintf( 'Dry run: se procesarían %d filas.', count( $rows ) ) );
        return;
    }

    $progress = \WP_CLI\Utils\make_progress_bar(
        'Importando posts de portfolio',
        count( $rows )
    );

    $creados  = 0;
    $errores  = 0;

    foreach ( $rows as $index => $row ) {
        $post_id = wp_insert_post( [
            'post_title'   => sanitize_text_field( $row['titulo'] ),
            'post_content' => wp_kses_post( $row['descripcion'] ),
            'post_type'    => 'portfolio',
            'post_status'  => 'publish',
        ], true );

        if ( is_wp_error( $post_id ) ) {
            WP_CLI::warning( sprintf(
                'Fila %d: error al crear post — %s',
                $index + 2,
                $post_id->get_error_message()
            ) );
            $errores++;
        } else {
            update_post_meta( $post_id, '_portfolio_cliente', sanitize_text_field( $row['cliente'] ) );
            update_post_meta( $post_id, '_portfolio_url', esc_url_raw( $row['url_proyecto'] ) );
            $creados++;
        }

        $progress->tick();
    }

    $progress->finish();

    WP_CLI::success( sprintf(
        'Importación completada: %d posts creados, %d errores.',
        $creados,
        $errores
    ) );
}
