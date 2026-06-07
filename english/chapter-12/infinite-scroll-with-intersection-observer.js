document.addEventListener( 'DOMContentLoaded', function() {
    const container = document.getElementById( 'portfolio-grid' );
    const sentinel  = document.getElementById( 'scroll-sentinel' ); // Element at the end of the grid

    if ( ! container || ! sentinel ) return;

    let currentPage = 1;
    let isLoading   = false;
    let hasMore     = true;

    const observer = new IntersectionObserver(
        async function( entries ) {
            const entry = entries[0];

            if ( ! entry.isIntersecting || isLoading || ! hasMore ) return;

            isLoading = true;

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

                if ( data.success && data.data.html ) {
                    container.insertAdjacentHTML( 'beforeend', data.data.html );
                    currentPage++;
                    hasMore = data.data.has_more;

                    if ( ! hasMore ) {
                        observer.disconnect();
                        sentinel.remove();
                    }
                }
            } catch ( error ) {
                console.error( 'Infinite scroll error:', error );
            } finally {
                isLoading = false;
            }
        },
        {
            rootMargin: '200px 0px', // Trigger 200px before the sentinel becomes visible
            threshold:  0,
        }
    );

    observer.observe( sentinel );
} );
