// src/portfolio.js

const container = document.querySelector( '#ninja-portfolio-grid' );

async function cargarPortfolio( pagina = 1 ) {
    const url = new URL( `${ninjaPortfolio.apiUrl}wp/v2/portfolio` );
    url.searchParams.set( 'per_page', '12' );
    url.searchParams.set( 'page', pagina );
    url.searchParams.set( '_fields', 'id,title,excerpt,link,featured_media_src_url' );

    const response = await fetch( url.toString(), {
        headers: {
            'X-WP-Nonce': ninjaPortfolio.nonce,
        },
    } );

    if ( ! response.ok ) {
        const error = await response.json().catch( () => null );
        const mensaje = error?.message ?? `HTTP ${response.status}`;
        throw new Error( mensaje );
    }

    return response.json();
}

function renderizarProyecto( proyecto ) {
    const article = document.createElement( 'article' );
    article.className = 'portfolio-item';
    article.innerHTML = `
        <a href="${proyecto.link}">
            ${proyecto.featured_media_src_url
                ? `<img src="${proyecto.featured_media_src_url}" alt="${proyecto.title.rendered}">`
                : ''
            }
            <h3>${proyecto.title.rendered}</h3>
            <div class="excerpt">${proyecto.excerpt.rendered}</div>
        </a>
    `;
    return article;
}

async function inicializar() {
    if ( ! container ) return;

    try {
        const proyectos = await cargarPortfolio();
        const fragmento = document.createDocumentFragment();

        for ( const proyecto of proyectos ) {
            fragmento.appendChild( renderizarProyecto( proyecto ) );
        }

        container.appendChild( fragmento );
    } catch ( error ) {
        container.innerHTML = `<p class="error">${ninjaPortfolio.errorMensaje}</p>`;
        console.error( 'Error al cargar el portfolio:', error );
    }
}

document.addEventListener( 'DOMContentLoaded', inicializar );
