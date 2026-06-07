// wp-content/themes/ninjatheme/sw.js
const CACHE_NAME = 'ninjatheme-v1';
const STATIC_ASSETS = [
    '/wp-content/themes/ninjatheme/dist/main.css',
    '/wp-content/themes/ninjatheme/dist/portfolio.js',
];

// Install: cache static assets
self.addEventListener( 'install', function( event ) {
    event.waitUntil(
        caches.open( CACHE_NAME ).then( function( cache ) {
            return cache.addAll( STATIC_ASSETS );
        } )
    );
} );

// Activate: clean up old caches
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

// Fetch: cache-first for static assets, network-first for HTML
self.addEventListener( 'fetch', function( event ) {
    const url = new URL( event.request.url );

    // Only intercept same-origin requests
    if ( url.origin !== location.origin ) {
        return;
    }

    // Static assets: cache-first
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

    // HTML: network-first (do not cache dynamic WordPress pages).
    // Do not intervene — let the request pass through unmodified.
} );
