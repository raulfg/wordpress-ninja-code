import { executeAbility } from '@wordpress/abilities';

// In a React component or a block
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
        console.error( 'Error loading projects:', error.message );
        return [];
    }
}
