add_action( 'wp_enqueue_scripts', function(): void {
    // Only if the browser supports Service Workers
    wp_add_inline_script(
        'ninja-portfolio',  // Attach to any already-enqueued script
        "if ( 'serviceWorker' in navigator ) {
            navigator.serviceWorker.register( '" . esc_url( get_template_directory_uri() ) . "/sw.js' )
                .then( function( reg ) {
                    console.log( '[SW] Registered:', reg.scope );
                } )
                .catch( function( err ) {
                    console.warn( '[SW] Registration error:', err );
                } );
        }",
        'after'
    );
} );
