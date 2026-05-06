add_action( 'wp_enqueue_scripts', function(): void {
    // Solo si el navegador soporta Service Workers
    wp_add_inline_script(
        'ninja-portfolio',  // Asociar a cualquier script ya encolado
        "if ( 'serviceWorker' in navigator ) {
            navigator.serviceWorker.register( '" . esc_url( get_template_directory_uri() ) . "/sw.js' )
                .then( function( reg ) {
                    console.log( '[SW] Registrado:', reg.scope );
                } )
                .catch( function( err ) {
                    console.warn( '[SW] Error de registro:', err );
                } );
        }",
        'after'
    );
} );
