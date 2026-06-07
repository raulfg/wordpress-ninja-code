import { executeAbility } from '@wordpress/abilities';

// En un componente React o en un bloque
async function loadFeaturedProjects() {
    try {
        const projects = await executeAbility(
            'ninja-portfolio/get-projects',
            {
                featured: true,
                limit: 6,
            }
        );
        return projects;
    } catch ( error ) {
        console.error( 'Error al cargar proyectos:', error.message );
        return [];
    }
}
