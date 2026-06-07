// src/portfolio/index.js

import { fetchPortfolio } from './api.js';
import { createPortfolioCard, showLoading } from './render.js';

const { currentCategory, perPage, i18n } = window.ninjaPortfolio;

let currentPage         = 1;
let currentCategorySlug = currentCategory;
let isLoading           = false;
let hasMore             = true;

const grid      = document.querySelector( '#portfolio-grid' );
const loadMoreBtn = document.querySelector( '#portfolio-load-more' );
const filterBtns  = document.querySelectorAll( '[data-portfolio-filter]' );

async function loadPortfolio( { reset = false } = {} ) {
    if ( isLoading || ( ! reset && ! hasMore ) ) {
        return;
    }

    isLoading = true;

    if ( reset ) {
        currentPage = 1;
        hasMore     = true;
        grid.innerHTML = '';
    }

    const loader = showLoading( grid );

    try {
        const { posts, totalPages } = await fetchPortfolio( {
            page:     currentPage,
            category: currentCategorySlug,
            perPage,
        } );

        loader.remove();

        const fragment = document.createDocumentFragment();
        posts.forEach( post => fragment.appendChild( createPortfolioCard( post ) ) );
        grid.appendChild( fragment );

        hasMore = currentPage < totalPages;
        currentPage++;

        if ( loadMoreBtn ) {
            loadMoreBtn.hidden  = ! hasMore;
            loadMoreBtn.textContent = hasMore ? i18n.loadMore : i18n.noMore;
        }

    } catch ( error ) {
        loader.textContent = i18n.error;
        loader.className   = 'portfolio-error';
        console.error( 'Portfolio load error:', error );
    } finally {
        isLoading = false;
    }
}

// Category filters
filterBtns.forEach( btn => {
    btn.addEventListener( 'click', () => {
        const category = btn.dataset.portfolioFilter;

        if ( category === currentCategorySlug ) {
            return;
        }

        // Update active button visual state
        filterBtns.forEach( b => b.classList.remove( 'is-active' ) );
        btn.classList.add( 'is-active' );

        currentCategorySlug = category;

        // Update URL without reloading (to allow sharing the filter)
        const url = new URL( window.location.href );
        if ( category ) {
            url.searchParams.set( 'cat', category );
        } else {
            url.searchParams.delete( 'cat' );
        }
        history.pushState( { category }, '', url );

        loadPortfolio( { reset: true } );
    } );
} );

// Load more
if ( loadMoreBtn ) {
    loadMoreBtn.addEventListener( 'click', () => loadPortfolio() );
}

// Initialize
if ( grid ) {
    // If projects were already rendered server-side (SSR), do not reload them
    const existingCards = grid.querySelectorAll( '.portfolio-card' );
    if ( existingCards.length === 0 ) {
        loadPortfolio();
    } else {
        // Adjust the page counter if the server already rendered projects
        currentPage = Math.ceil( existingCards.length / perPage ) + 1;
        hasMore     = existingCards.length >= perPage;
        if ( loadMoreBtn ) {
            loadMoreBtn.hidden = ! hasMore;
        }
    }
}
