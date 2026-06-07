add_action( 'admin_footer-edit.php', function(): void {
    global $post_type;

    if ( 'portfolio' !== $post_type ) {
        return;
    }
    ?>
    <script>
    ( function( $ ) {
        $( '#the-list' ).on( 'click', '.editinline', function() {
            const postId   = $( this ).closest( 'tr' ).attr( 'id' ).replace( 'post-', '' );
            const client   = $( `#portfolio_inline_${postId} .portfolio_client` ).text();
            const featured = $( `#portfolio_inline_${postId} .portfolio_featured` ).text() === '1';

            $( 'input[name="_npe_client_name"]', '.inline-edit-row' ).val( client );
            $( 'input[name="_npe_is_featured"]', '.inline-edit-row' ).prop( 'checked', featured );
        } );
    }( jQuery ) );
    </script>
    <?php
} );
