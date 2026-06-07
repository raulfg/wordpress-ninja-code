<?php

declare(strict_types=1);

namespace NinjaTheme\PostTypes;

class Portfolio
{
    public function __construct()
    {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void
    {
        register_post_type( 'portfolio', [
            'labels' => [
                'name'          => 'Portfolio',
                'singular_name' => 'Project',
                'add_new_item'  => 'Add project',
                'edit_item'     => 'Edit project',
                'view_item'     => 'View project',
                'all_items'     => 'All projects',
            ],
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
            'menu_icon'    => 'dashicons-portfolio',
            'rewrite'      => ['slug' => 'portfolio'],
        ]);
    }
}
