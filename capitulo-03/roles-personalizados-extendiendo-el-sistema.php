add_role(
    'content_manager',
    'Content Manager',
    array(
        // Todas las capabilities de Editor
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        // ... (todas las de Editor)

        // Más: gestionar usuarios
        'edit_users' => true,
        'create_users' => true,
        'delete_users' => true,
        'list_users' => true,
    )
);
