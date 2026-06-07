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
                'singular_name' => 'Project',
                'add_new_item'  => 'Add project',
                'all_items'     => 'All projects',
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
                'name'          => 'Case Studies',
                'singular_name' => 'Case Study',
                'add_new_item'  => 'Add case study',
            ],
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author' ],
            'menu_icon'    => 'dashicons-businessman',
            'rewrite'      => [ 'slug' => 'case-studies' ],
        ];
    }
}
