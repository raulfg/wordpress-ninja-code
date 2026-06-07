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
            'name'                  => _x( 'Proyectos', 'Post Type General Name', 'ninja-portfolio' ),
            'singular_name'         => _x( 'Proyecto', 'Post Type Singular Name', 'ninja-portfolio' ),
            'menu_name'             => __( 'Portfolio', 'ninja-portfolio' ),
            'name_admin_bar'        => __( 'Proyecto', 'ninja-portfolio' ),
            'add_new'               => __( 'Añadir nuevo', 'ninja-portfolio' ),
            'add_new_item'          => __( 'Añadir nuevo proyecto', 'ninja-portfolio' ),
            'edit_item'             => __( 'Editar proyecto', 'ninja-portfolio' ),
            'view_item'             => __( 'Ver proyecto', 'ninja-portfolio' ),
            'all_items'             => __( 'Todos los proyectos', 'ninja-portfolio' ),
            'not_found'             => __( 'No se encontraron proyectos.', 'ninja-portfolio' ),
            'not_found_in_trash'    => __( 'No hay proyectos en la papelera.', 'ninja-portfolio' ),
            'featured_image'        => __( 'Imagen del proyecto', 'ninja-portfolio' ),
            'set_featured_image'    => __( 'Establecer imagen del proyecto', 'ninja-portfolio' ),
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
