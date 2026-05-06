// src/portfolio/api.js

const { apiUrl, nonce } = window.ninjaPortfolio;

export async function fetchPortfolio( { page = 1, category = '', perPage = 12 } = {} ) {
    const url = new URL( apiUrl );

    url.searchParams.set( 'page', page );
    url.searchParams.set( 'per_page', perPage );

    if ( category ) {
        url.searchParams.set( 'category', category );
    }

    const response = await fetch( url.toString(), {
        headers: {
            'X-WP-Nonce': nonce,
        },
    } );

    if ( ! response.ok ) {
        const error = await response.json().catch( () => null );
        throw new Error( error?.message ?? `HTTP ${response.status}` );
    }

    return {
        posts:      await response.json(),
        total:      parseInt( response.headers.get( 'X-WP-Total' ) ?? '0', 10 ),
        totalPages: parseInt( response.headers.get( 'X-WP-TotalPages' ) ?? '1', 10 ),
    };
}
