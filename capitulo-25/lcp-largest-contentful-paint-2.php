add_filter( 'upload_mimes', function( array $mimes ): array {
    $mimes['webp'] = 'image/webp';
    return $mimes;
} );

// WordPress 6.5+: controlar la conversión automática de imágenes al subir
add_filter(
    'wp_upload_image_mime_transform',
    function ( array $transforms, string $mime ): array {
        if ( 'image/jpeg' === $mime ) {
            return [ 'image/webp' ];
        }
        return $transforms;
    },
    10,
    2
);
