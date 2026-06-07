import apiFetch from '@wordpress/api-fetch';

// GET — fetch portfolio posts
const projects = await apiFetch( {
    path: '/wp/v2/portfolio?per_page=6',
} );

// POST — create a post
const newPost = await apiFetch( {
    path: '/wp/v2/posts',
    method: 'POST',
    data: {
        title:   'New project',
        status:  'draft',
        content: 'Project description.',
    },
} );

// DELETE — delete a post
await apiFetch( {
    path: `/wp/v2/posts/${id}`,
    method: 'DELETE',
} );
