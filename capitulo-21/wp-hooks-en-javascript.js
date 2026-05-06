import { addAction, addFilter, doAction, applyFilters } from '@wordpress/hooks';

// Registrar una acción
addAction(
    'ninja.portfolio.loaded',  // nombre del hook
    'ninja-theme',             // namespace del plugin/tema
    ( proyectos ) => {
        console.log( `${proyectos.length} proyectos cargados` );
        // Enviar evento de analítica, actualizar estado, etc.
    }
);

// Disparar la acción
const proyectos = await cargarPortfolio();
doAction( 'ninja.portfolio.loaded', proyectos );

// Registrar un filtro que transforma los proyectos
addFilter(
    'ninja.portfolio.items',
    'ninja-theme',
    ( items ) => items.filter( item => item.featured )
);

// Aplicar el filtro
const items = applyFilters( 'ninja.portfolio.items', proyectos );
