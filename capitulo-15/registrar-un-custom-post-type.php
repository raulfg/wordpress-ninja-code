add_action( 'init', 'ninjatheme_register_portfolio_cpt' );

function ninjatheme_register_portfolio_cpt(): void {
	$labels = [
		'name'                  => 'Proyectos',
		'singular_name'         => 'Proyecto',
		'menu_name'             => 'Portfolio',
		'add_new'               => 'Añadir proyecto',
		'add_new_item'          => 'Añadir nuevo proyecto',
		'new_item'              => 'Nuevo proyecto',
		'edit_item'             => 'Editar proyecto',
		'view_item'             => 'Ver proyecto',
		'view_items'            => 'Ver proyectos',
		'all_items'             => 'Todos los proyectos',
		'search_items'          => 'Buscar proyectos',
		'not_found'             => 'No se encontraron proyectos',
		'not_found_in_trash'    => 'No hay proyectos en la papelera',
		'featured_image'        => 'Imagen del proyecto',
		'set_featured_image'    => 'Establecer imagen del proyecto',
		'remove_featured_image' => 'Eliminar imagen del proyecto',
		'archives'              => 'Archivo de proyectos',
	];

	$args = [
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'portfolio' ],
		'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-portfolio',
		'menu_position' => 5,
	];

	register_post_type( 'portfolio', $args );
}
