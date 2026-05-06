add_action( 'init', 'ninjatheme_register_portfolio_taxonomy' );

function ninjatheme_register_portfolio_taxonomy(): void {
	$labels = [
		'name'              => 'Categorías de portfolio',
		'singular_name'     => 'Categoría de portfolio',
		'menu_name'         => 'Categorías',
		'all_items'         => 'Todas las categorías',
		'edit_item'         => 'Editar categoría',
		'add_new_item'      => 'Añadir categoría',
		'search_items'      => 'Buscar categorías',
		'not_found'         => 'No se encontraron categorías',
		'parent_item'       => 'Categoría padre',
		'parent_item_colon' => 'Categoría padre:',
	];

	$args = [
		'labels'       => $labels,
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'portfolio-categoria' ],
		'show_in_rest' => true,
	];

	register_taxonomy( 'portfolio-category', 'portfolio', $args );
}
