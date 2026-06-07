add_role(
    'content_manager',
    'Content Manager',
    array(
        // All Editor capabilities
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        'publish_posts' => true,
        'edit_published_posts' => true,
        // ... (all Editor ones)

        // Plus: manage users
        'edit_users' => true,
        'create_users' => true,
        'delete_users' => true,
        'list_users' => true,
    )
);
