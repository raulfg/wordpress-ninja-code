// src/portfolio-filter/view.js
import { store, getContext, getElement } from '@wordpress/interactivity';

const { state, actions } = store( 'ninjatheme/portfolio-filter', {
    state: {
        get filterLabel() {
            if ( state.filter === 'all' ) {
                return `${ state.totalProjects } projects`;
            }
            const visible = document.querySelectorAll(
                '[data-wp-interactive] article:not(.hidden)'
            ).length;
            return `${ visible } projects`;
        },

        get isFilterActive() {
            const { slug } = getContext();
            return state.filter === ( slug ?? 'all' );
        },

        get isProjectHidden() {
            if ( state.filter === 'all' ) {
                return false;
            }
            const { categories } = getContext();
            return ! categories.includes( state.filter );
        },
    },

    actions: {
        setFilter() {
            const { slug } = getContext();
            const element   = getElement();
            const filter    = element.ref.dataset.filter ?? slug ?? 'all';
            state.filter    = filter;
        },
    },
} );
