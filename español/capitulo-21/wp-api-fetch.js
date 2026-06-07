import apiFetch from '@wordpress/api-fetch';

// GET — obtener posts del portfolio
const proyectos = await apiFetch( {
    path: '/wp/v2/portfolio?per_page=6',
} );

// POST — crear una entrada
const nueva = await apiFetch( {
    path: '/wp/v2/posts',
    method: 'POST',
    data: {
        title:   'Nuevo proyecto',
        status:  'draft',
        content: 'Descripción del proyecto.',
    },
} );

// DELETE — eliminar una entrada
await apiFetch( {
    path: `/wp/v2/posts/${id}`,
    method: 'DELETE',
} );
