<?php
namespace NinjaPortfolio\PostTypes;

class Portfolio
{
    public function __construct()
    {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register(): void
    {
        $labels = [
            'name'                  => _x( 'Projects', 'Post Type General Name', 'ninja-portfolio' ),
            'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'ninja-portfolio' ),
            'menu_name'             => __( 'Portfolio', 'ninja-portfolio' ),
            'name_admin_bar'        => __( 'Project', 'ninja-portfolio' ),
            'add_new'               => __( 'Add new', 'ninja-portfolio' ),
            'add_new_item'          => __( 'Add new project', 'ninja-portfolio' ),
            'edit_item'             => __( 'Edit project', 'ninja-portfolio' ),
            'view_item'             => __( 'View project', 'ninja-portfolio' ),
            'all_items'             => __( 'All projects', 'ninja-portfolio' ),
            'not_found'             => __( 'No projects found.', 'ninja-portfolio' ),
            'not_found_in_trash'    => __( 'No projects in the trash.', 'ninja-portfolio' ),
            'featured_image'        => __( 'Project image', 'ninja-portfolio' ),
            'set_featured_image'    => __( 'Set project image', 'ninja-portfolio' ),
        ];

        register_post_type( 'portfolio', [
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => [ 'slug' => 'portfolio', 'with_front' => false ],
            'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
            'show_in_rest'        => true,
            'menu_icon'           => 'dashicons-portfolio',
            'menu_position'       => 5,
            'taxonomies'          => [ 'portfolio-category' ],
        ] );
    }
}
