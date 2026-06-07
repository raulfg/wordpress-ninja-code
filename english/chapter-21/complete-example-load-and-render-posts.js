// src/portfolio.js

const container = document.querySelector( '#ninja-portfolio-grid' );

async function loadPortfolio( page = 1 ) {
    const url = new URL( `${ninjaPortfolio.apiUrl}wp/v2/portfolio` );
    url.searchParams.set( 'per_page', '12' );
    url.searchParams.set( 'page', page );
    url.searchParams.set( '_fields', 'id,title,excerpt,link,featured_media_src_url' );

    const response = await fetch( url.toString(), {
        headers: {
            'X-WP-Nonce': ninjaPortfolio.nonce,
        },
    } );

    if ( ! response.ok ) {
        const error = await response.json().catch( () => null );
        const message = error?.message ?? `HTTP ${response.status}`;
        throw new Error( message );
    }

    return response.json();
}

function renderProject( project ) {
    const article = document.createElement( 'article' );
    article.className = 'portfolio-item';
    article.innerHTML = `
        <a href="${project.link}">
            ${project.featured_media_src_url
                ? `<img src="${project.featured_media_src_url}" alt="${project.title.rendered}">`
                : ''
            }
            <h3>${project.title.rendered}</h3>
            <div class="excerpt">${project.excerpt.rendered}</div>
        </a>
    `;
    return article;
}

async function initialize() {
    if ( ! container ) return;

    try {
        const projects = await loadPortfolio();
        const fragment = document.createDocumentFragment();

        for ( const project of projects ) {
            fragment.appendChild( renderProject( project ) );
        }

        container.appendChild( fragment );
    } catch ( error ) {
        container.innerHTML = `<p class="error">${ninjaPortfolio.errorMessage}</p>`;
        console.error( 'Error loading portfolio:', error );
    }
}

document.addEventListener( 'DOMContentLoaded', initialize );
