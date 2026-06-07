// src/portfolio-filter/view.js
import { store, getContext, getElement } from '@wordpress/interactivity';

const { state, actions } = store( 'ninjatheme/portfolio-filter', {
    state: {
        activeCategory: '',
        isLoading: false,
    },

    actions: {
        setFilter() {
            const context = getContext();
            // Toggle: if the active category is the same, deactivate it
            state.activeCategory =
                state.activeCategory === context.slug ? '' : context.slug;
        },

        async loadMorePosts() {
            state.isLoading = true;

            try {
                const response = await fetch(
                    `/wp-json/wp/v2/portfolio?per_page=6&offset=${ state.loadedCount }`
                );
                const posts = await response.json();

                state.posts    = [ ...state.posts, ...posts ];
                state.loadedCount += posts.length;
                state.hasMore  = posts.length === 6;
            } finally {
                state.isLoading = false;
            }
        },
    },

    callbacks: {
        onFilterChange() {
            // Runs when state.activeCategory changes.
            // Useful for side effects: analytics, URL update, etc.
            const url = new URL( window.location );
            if ( state.activeCategory ) {
                url.searchParams.set( 'category', state.activeCategory );
            } else {
                url.searchParams.delete( 'category' );
            }
            window.history.replaceState( {}, '', url );
        },
    },
} );
