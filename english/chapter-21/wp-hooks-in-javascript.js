import { addAction, addFilter, doAction, applyFilters } from '@wordpress/hooks';

// Register an action
addAction(
    'ninja.portfolio.loaded',  // hook name
    'ninja-theme',             // plugin/theme namespace
    ( projects ) => {
        console.log( `${projects.length} projects loaded` );
        // Send analytics event, update state, etc.
    }
);

// Trigger the action
const projects = await loadPortfolio();
doAction( 'ninja.portfolio.loaded', projects );

// Register a filter that transforms projects
addFilter(
    'ninja.portfolio.items',
    'ninja-theme',
    ( items ) => items.filter( item => item.featured )
);

// Apply the filter
const items = applyFilters( 'ninja.portfolio.items', projects );
