add_filter( 'wp_handle_upload_prefilter', function( array $file ): array {
    // Verify that the extension and MIME type match
    $allowed_mimes = [
        'jpg|jpeg|jpe'  => 'image/jpeg',
        'gif'           => 'image/gif',
        'png'           => 'image/png',
        'webp'          => 'image/webp',
        'pdf'           => 'application/pdf',
    ];

    $file_type = wp_check_filetype( $file['name'], $allowed_mimes );

    if ( ! $file_type['type'] ) {
        $file['error'] = __( 'File type not allowed by the site security policies.', 'ninjatheme' );
        return $file;
    }

    // Check the maximum size per type
    $max_sizes = [
        'image/jpeg' => 5 * MB_IN_BYTES,
        'image/png'  => 5 * MB_IN_BYTES,
        'application/pdf' => 20 * MB_IN_BYTES,
    ];

    $max = $max_sizes[ $file_type['type'] ] ?? 2 * MB_IN_BYTES;
    if ( $file['size'] > $max ) {
        $file['error'] = sprintf(
            __( 'The file exceeds the maximum allowed size (%s).', 'ninjatheme' ),
            size_format( $max )
        );
    }

    return $file;
} );
