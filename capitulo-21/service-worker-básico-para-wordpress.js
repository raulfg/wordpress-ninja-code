// wp-content/themes/ninjatheme/sw.js
const CACHE_NAME = 'ninjatheme-v1';
const STATIC_ASSETS = [
    '/wp-content/themes/ninjatheme/dist/main.css',
    '/wp-content/themes/ninjatheme/dist/portfolio.js',
];

// Instalar: cachear los assets estáticos
self.addEventListener( 'install', function( event ) {
    event.waitUntil(
        caches.open( CACHE_NAME ).then( function( cache ) {
            return cache.addAll( STATIC_ASSETS );
        } )
    );
} );

// Activar: limpiar caches antiguas
self.addEventListener( 'activate', function( event ) {
    event.waitUntil(
        caches.keys().then( function( cacheNames ) {
            return Promise.all(
                cacheNames
                    .filter( name => name !== CACHE_NAME )
                    .map( name => caches.delete( name ) )
            );
        } )
    );
} );

// Fetch: cache-first para assets estáticos, network-first para HTML
self.addEventListener( 'fetch', function( event ) {
    const url = new URL( event.request.url );

    // Solo interceptar peticiones del mismo origen
    if ( url.origin !== location.origin ) {
        return;
    }

    // Assets estáticos: cache-first
    const isStaticAsset = url.pathname.startsWith( '/wp-content/' )
        && ( url.pathname.endsWith( '.css' )
            || url.pathname.endsWith( '.js' )
            || url.pathname.endsWith( '.woff2' ) );

    if ( isStaticAsset ) {
        event.respondWith(
            caches.match( event.request ).then( function( cached ) {
                return cached || fetch( event.request ).then( function( response ) {
                    const clone = response.clone();
                    caches.open( CACHE_NAME )
                    .then( cache => cache.put( event.request, clone ) )
                    .catch( () => {} );
                    return response;
                } );
            } )
        );
        return;
    }

    // HTML: network-first (no cachear páginas WordPress dinámicas)
    // No intervenir — dejar pasar la petición sin modificar
} );
