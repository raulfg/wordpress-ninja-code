add_action( 'init', 'ninjatheme_register_portfolio_cpt' );

function ninjatheme_register_portfolio_cpt(): void {
	$labels = [
		'name'                  => 'Projects',
		'singular_name'         => 'Project',
		'menu_name'             => 'Portfolio',
		'add_new'               => 'Add project',
		'add_new_item'          => 'Add new project',
		'new_item'              => 'New project',
		'edit_item'             => 'Edit project',
		'view_item'             => 'View project',
		'view_items'            => 'View projects',
		'all_items'             => 'All projects',
		'search_items'          => 'Search projects',
		'not_found'             => 'No projects found',
		'not_found_in_trash'    => 'No projects in the trash',
		'featured_image'        => 'Project image',
		'set_featured_image'    => 'Set project image',
		'remove_featured_image' => 'Remove project image',
		'archives'              => 'Project archives',
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
