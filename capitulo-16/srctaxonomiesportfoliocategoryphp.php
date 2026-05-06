<?php

declare(strict_types=1);

namespace NinjaTheme\Taxonomies;

class PortfolioCategory
{
    public function __construct()
    {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void
    {
        register_taxonomy( 'portfolio-category', [ 'portfolio' ], [
            'labels' => [
                'name'          => 'Categorías de portfolio',
                'singular_name' => 'Categoría de portfolio',
                'all_items'     => 'Todas las categorías',
                'edit_item'     => 'Editar categoría',
                'add_new_item'  => 'Añadir categoría',
            ],
            'hierarchical'  => true,
            'show_in_rest'  => true,
            'rewrite'       => ['slug' => 'portfolio-categoria'],
        ]);
    }
}
