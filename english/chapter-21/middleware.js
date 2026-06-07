import apiFetch from '@wordpress/api-fetch';

// Middleware that adds a custom header to all requests
apiFetch.use( ( options, next ) => {
    return next( {
        ...options,
        headers: {
            ...( options.headers ?? {} ),
            'X-Ninja-Version': '1.0',
        },
    } );
} );

// Logging middleware in development
if ( process.env.NODE_ENV === 'development' ) {
    apiFetch.use( ( options, next ) => {
        console.group( `apiFetch → ${options.method ?? 'GET'} ${options.path}` );
        const start = Date.now();
        return next( options ).then( response => {
            console.log( `${Date.now() - start}ms`, response );
            console.groupEnd();
            return response;
        } ).catch( error => {
            console.error( error );
            console.groupEnd();
            throw error;
        } );
    } );
}
