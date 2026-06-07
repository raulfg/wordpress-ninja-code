add_action( 'init', 'ninjatheme_register_portfolio_taxonomy' );

function ninjatheme_register_portfolio_taxonomy(): void {
	$labels = [
		'name'              => 'Portfolio categories',
		'singular_name'     => 'Portfolio category',
		'menu_name'         => 'Categories',
		'all_items'         => 'All categories',
		'edit_item'         => 'Edit category',
		'add_new_item'      => 'Add category',
		'search_items'      => 'Search categories',
		'not_found'         => 'No categories found',
		'parent_item'       => 'Parent category',
		'parent_item_colon' => 'Parent category:',
	];

	$args = [
		'labels'       => $labels,
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'portfolio-category' ],
		'show_in_rest' => true,
	];

	register_taxonomy( 'portfolio-category', 'portfolio', $args );
}
