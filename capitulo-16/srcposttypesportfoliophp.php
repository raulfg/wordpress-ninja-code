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
                'singular_name' => 'Proyecto',
                'add_new_item'  => 'Añadir proyecto',
                'edit_item'     => 'Editar proyecto',
                'view_item'     => 'Ver proyecto',
                'all_items'     => 'Todos los proyectos',
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
