<?php

namespace NinjaTheme\PostTypes;

class Portfolio extends AbstractPostType
{
    protected function get_post_type(): string
    {
        return 'portfolio';
    }

    protected function get_args(): array
    {
        return [
            'labels' => [
                'name'          => 'Portfolio',
                'singular_name' => 'Proyecto',
                'add_new_item'  => 'Añadir proyecto',
                'all_items'     => 'Todos los proyectos',
            ],
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'menu_icon'    => 'dashicons-portfolio',
            'rewrite'      => [ 'slug' => 'portfolio' ],
        ];
    }
}

class CaseStudy extends AbstractPostType
{
    protected function get_post_type(): string
    {
        return 'case-study';
    }

    protected function get_args(): array
    {
        return [
            'labels' => [
                'name'          => 'Casos de estudio',
                'singular_name' => 'Caso de estudio',
                'add_new_item'  => 'Añadir caso de estudio',
            ],
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author' ],
            'menu_icon'    => 'dashicons-businessman',
            'rewrite'      => [ 'slug' => 'casos-de-estudio' ],
        ];
    }
}
