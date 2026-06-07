// Pass configuration data from PHP
// (wp_localize_script or wp_add_inline_script)
// window.ninjaAjax = { url: '/wp-admin/admin-ajax.php', nonce: '...' }

document.addEventListener( 'DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById( 'load-more' );
    const container   = document.getElementById( 'portfolio-grid' );

    if ( ! loadMoreBtn || ! container ) return;

    let currentPage = 1;
    let isLoading   = false;

    loadMoreBtn.addEventListener( 'click', async function() {
        if ( isLoading ) return;

        isLoading = true;
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';

        try {
            const formData = new FormData();
            formData.append( 'action',    'ninja_load_more' );
            formData.append( 'nonce',     window.ninjaAjax.nonce );
            formData.append( 'page',      String( currentPage + 1 ) );
            formData.append( 'post_type', 'portfolio' );

            const response = await fetch( window.ninjaAjax.url, {
                method: 'POST',
                body:   formData,
            } );

            const data = await response.json();

            if ( ! data.success ) {
                console.error( 'Load error:', data.data );
                return;
            }

            if ( data.data.html ) {
                // Insert the HTML of the new cards
                container.insertAdjacentHTML( 'beforeend', data.data.html );
                currentPage++;
            }

            // Hide the button if there are no more pages
            if ( ! data.data.has_more ) {
                loadMoreBtn.closest( '.load-more-wrap' )?.remove();
            } else {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'Load more';
            }
        } catch ( error ) {
            console.error( 'Network error:', error );
        } finally {
            isLoading = false;
        }
    } );
} );
