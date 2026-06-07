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
                'name'          => 'Portfolio Categories',
                'singular_name' => 'Portfolio Category',
                'all_items'     => 'All categories',
                'edit_item'     => 'Edit category',
                'add_new_item'  => 'Add category',
            ],
            'hierarchical'  => true,
            'show_in_rest'  => true,
            'rewrite'       => ['slug' => 'portfolio-category'],
        ]);
    }
}
