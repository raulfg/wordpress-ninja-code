add_filter( 'wp_handle_upload_prefilter', function( array $file ): array {
    // Verificar que la extensión y el MIME coinciden
    $allowed_mimes = [
        'jpg|jpeg|jpe'  => 'image/jpeg',
        'gif'           => 'image/gif',
        'png'           => 'image/png',
        'webp'          => 'image/webp',
        'pdf'           => 'application/pdf',
    ];

    $file_type = wp_check_filetype( $file['name'], $allowed_mimes );

    if ( ! $file_type['type'] ) {
        $file['error'] = __( 'Tipo de archivo no permitido por las políticas de seguridad del sitio.', 'ninjatheme' );
        return $file;
    }

    // Verificar el tamaño máximo por tipo
    $max_sizes = [
        'image/jpeg' => 5 * MB_IN_BYTES,
        'image/png'  => 5 * MB_IN_BYTES,
        'application/pdf' => 20 * MB_IN_BYTES,
    ];

    $max = $max_sizes[ $file_type['type'] ] ?? 2 * MB_IN_BYTES;
    if ( $file['size'] > $max ) {
        $file['error'] = sprintf(
            __( 'El archivo supera el tamaño máximo permitido (%s).', 'ninjatheme' ),
            size_format( $max )
        );
    }

    return $file;
} );
