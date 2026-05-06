// Pasar los datos de configuración desde PHP
// (wp_localize_script o wp_add_inline_script)
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
        loadMoreBtn.textContent = 'Cargando...';

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
                console.error( 'Error al cargar:', data.data );
                return;
            }

            if ( data.data.html ) {
                // Insertar el HTML de las nuevas cards
                container.insertAdjacentHTML( 'beforeend', data.data.html );
                currentPage++;
            }

            // Ocultar el botón si no hay más páginas
            if ( ! data.data.has_more ) {
                loadMoreBtn.closest( '.load-more-wrap' )?.remove();
            } else {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'Cargar más';
            }
        } catch ( error ) {
            console.error( 'Error de red:', error );
        } finally {
            isLoading = false;
        }
    } );
} );
